import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";
import bcrypt from "bcryptjs";

export async function PUT(
  request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  try {
    const { id } = await params;
    const body = await request.json();
    const { password, full_name, email, role, is_active } = body;

    if (password) {
      // Update with new password
      const hashedPassword = await bcrypt.hash(password, 10);
      await query(
        `UPDATE admin_users 
         SET password = ?, full_name = ?, email = ?, role = ?, is_active = ?,
             updated_at = NOW()
         WHERE id = ?`,
        [
          hashedPassword,
          full_name || "",
          email || "",
          role || "editor",
          is_active !== undefined ? is_active : 1,
          id,
        ]
      );
    } else {
      // Update without password
      await query(
        `UPDATE admin_users 
         SET full_name = ?, email = ?, role = ?, is_active = ?,
             updated_at = NOW()
         WHERE id = ?`,
        [
          full_name || "",
          email || "",
          role || "editor",
          is_active !== undefined ? is_active : 1,
          id,
        ]
      );
    }

    return NextResponse.json({
      success: true,
      message: "User updated successfully",
    });
  } catch (error) {
    console.error("Error updating user:", error);
    return NextResponse.json(
      { success: false, message: "Failed to update user" },
      { status: 500 }
    );
  }
}

export async function DELETE(
  _request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  try {
    const { id } = await params;

    // Don't allow deleting the main admin
    const users = await query<{ username: string }[]>(
      "SELECT username FROM admin_users WHERE id = ?",
      [id]
    );

    if (users[0]?.username === "admin") {
      return NextResponse.json(
        { success: false, message: "Cannot delete main admin account" },
        { status: 400 }
      );
    }

    await query("DELETE FROM admin_users WHERE id = ?", [id]);

    return NextResponse.json({
      success: true,
      message: "User deleted successfully",
    });
  } catch (error) {
    console.error("Error deleting user:", error);
    return NextResponse.json(
      { success: false, message: "Failed to delete user" },
      { status: 500 }
    );
  }
}

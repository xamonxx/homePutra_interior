import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";
import { AdminUser } from "@/types";
import bcrypt from "bcryptjs";

export async function GET() {
  try {
    const users = await query<AdminUser[]>(
      "SELECT id, username, full_name, email, role, is_active, last_login FROM admin_users ORDER BY id ASC"
    );
    return NextResponse.json({ success: true, data: users });
  } catch (error) {
    console.error("Error fetching users:", error);
    return NextResponse.json(
      { success: false, message: "Failed to fetch users" },
      { status: 500 }
    );
  }
}

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { username, password, full_name, email, role } = body;

    if (!username || !password) {
      return NextResponse.json(
        { success: false, message: "Username and password are required" },
        { status: 400 }
      );
    }

    // Check if username exists
    const existing = await query<AdminUser[]>(
      "SELECT id FROM admin_users WHERE username = ?",
      [username]
    );

    if (existing.length > 0) {
      return NextResponse.json(
        { success: false, message: "Username already exists" },
        { status: 400 }
      );
    }

    // Hash password
    const hashedPassword = await bcrypt.hash(password, 10);

    await query(
      `INSERT INTO admin_users (username, password, full_name, email, role, is_active, created_at) 
       VALUES (?, ?, ?, ?, ?, 1, NOW())`,
      [username, hashedPassword, full_name || "", email || "", role || "editor"]
    );

    return NextResponse.json({
      success: true,
      message: "User created successfully",
    });
  } catch (error) {
    console.error("Error creating user:", error);
    return NextResponse.json(
      { success: false, message: "Failed to create user" },
      { status: 500 }
    );
  }
}

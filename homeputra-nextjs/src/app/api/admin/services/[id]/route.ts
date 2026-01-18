import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";

export async function PUT(
  request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  try {
    const { id } = await params;
    const body = await request.json();
    const { title, description, icon, display_order, is_active } = body;

    await query(
      `UPDATE services 
       SET title = ?, description = ?, icon = ?, display_order = ?, is_active = ?,
           updated_at = NOW()
       WHERE id = ?`,
      [
        title,
        description || "",
        icon || "home",
        display_order || 0,
        is_active !== undefined ? is_active : 1,
        id,
      ]
    );

    return NextResponse.json({
      success: true,
      message: "Service updated successfully",
    });
  } catch (error) {
    console.error("Error updating service:", error);
    return NextResponse.json(
      { success: false, message: "Failed to update service" },
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

    await query("DELETE FROM services WHERE id = ?", [id]);

    return NextResponse.json({
      success: true,
      message: "Service deleted successfully",
    });
  } catch (error) {
    console.error("Error deleting service:", error);
    return NextResponse.json(
      { success: false, message: "Failed to delete service" },
      { status: 500 }
    );
  }
}

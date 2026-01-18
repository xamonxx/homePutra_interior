import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";

export async function PUT(
  request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  try {
    const { id } = await params;
    const body = await request.json();
    const { title, category, description, image, display_order, is_active } = body;

    await query(
      `UPDATE portfolio 
       SET title = ?, category = ?, description = ?, image = ?, 
           display_order = ?, is_active = ?, updated_at = NOW()
       WHERE id = ?`,
      [
        title,
        category || "",
        description || "",
        image || "",
        display_order || 0,
        is_active !== undefined ? is_active : 1,
        id,
      ]
    );

    return NextResponse.json({
      success: true,
      message: "Portfolio updated successfully",
    });
  } catch (error) {
    console.error("Error updating portfolio:", error);
    return NextResponse.json(
      { success: false, message: "Failed to update portfolio" },
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

    await query("DELETE FROM portfolio WHERE id = ?", [id]);

    return NextResponse.json({
      success: true,
      message: "Portfolio deleted successfully",
    });
  } catch (error) {
    console.error("Error deleting portfolio:", error);
    return NextResponse.json(
      { success: false, message: "Failed to delete portfolio" },
      { status: 500 }
    );
  }
}

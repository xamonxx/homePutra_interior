import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";

export async function PUT(
  request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  try {
    const { id } = await params;
    const body = await request.json();
    const { stat_number, stat_suffix, stat_label, display_order, is_active } = body;

    await query(
      `UPDATE statistics 
       SET stat_number = ?, stat_suffix = ?, stat_label = ?, display_order = ?, is_active = ?,
           updated_at = NOW()
       WHERE id = ?`,
      [
        stat_number,
        stat_suffix || "",
        stat_label,
        display_order || 0,
        is_active !== undefined ? is_active : 1,
        id,
      ]
    );

    return NextResponse.json({
      success: true,
      message: "Statistic updated successfully",
    });
  } catch (error) {
    console.error("Error updating statistic:", error);
    return NextResponse.json(
      { success: false, message: "Failed to update statistic" },
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

    await query("DELETE FROM statistics WHERE id = ?", [id]);

    return NextResponse.json({
      success: true,
      message: "Statistic deleted successfully",
    });
  } catch (error) {
    console.error("Error deleting statistic:", error);
    return NextResponse.json(
      { success: false, message: "Failed to delete statistic" },
      { status: 500 }
    );
  }
}

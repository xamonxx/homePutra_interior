import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";

export async function PUT(
  request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  try {
    const { id } = await params;
    const body = await request.json();
    const {
      client_name,
      client_location,
      client_image,
      testimonial_text,
      rating,
      display_order,
      is_active,
    } = body;

    await query(
      `UPDATE testimonials 
       SET client_name = ?, client_location = ?, client_image = ?, 
           testimonial_text = ?, rating = ?, display_order = ?, is_active = ?,
           updated_at = NOW()
       WHERE id = ?`,
      [
        client_name,
        client_location || "",
        client_image || "",
        testimonial_text,
        rating || 5,
        display_order || 0,
        is_active !== undefined ? is_active : 1,
        id,
      ]
    );

    return NextResponse.json({
      success: true,
      message: "Testimonial updated successfully",
    });
  } catch (error) {
    console.error("Error updating testimonial:", error);
    return NextResponse.json(
      { success: false, message: "Failed to update testimonial" },
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

    await query("DELETE FROM testimonials WHERE id = ?", [id]);

    return NextResponse.json({
      success: true,
      message: "Testimonial deleted successfully",
    });
  } catch (error) {
    console.error("Error deleting testimonial:", error);
    return NextResponse.json(
      { success: false, message: "Failed to delete testimonial" },
      { status: 500 }
    );
  }
}

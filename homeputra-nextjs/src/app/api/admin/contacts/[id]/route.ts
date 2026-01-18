import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";

export async function PUT(
  request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  try {
    const { id } = await params;
    const body = await request.json();
    const { is_read } = body;

    await query("UPDATE contact_submissions SET is_read = ? WHERE id = ?", [
      is_read,
      id,
    ]);

    return NextResponse.json({
      success: true,
      message: "Contact updated successfully",
    });
  } catch (error) {
    console.error("Error updating contact:", error);
    return NextResponse.json(
      { success: false, message: "Failed to update contact" },
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

    await query("DELETE FROM contact_submissions WHERE id = ?", [id]);

    return NextResponse.json({
      success: true,
      message: "Contact deleted successfully",
    });
  } catch (error) {
    console.error("Error deleting contact:", error);
    return NextResponse.json(
      { success: false, message: "Failed to delete contact" },
      { status: 500 }
    );
  }
}

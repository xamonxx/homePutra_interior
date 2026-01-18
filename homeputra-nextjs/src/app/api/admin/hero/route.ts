import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";
import { HeroSection } from "@/types";

export async function GET() {
  try {
    const heroes = await query<HeroSection[]>(
      "SELECT * FROM hero_section WHERE is_active = 1 LIMIT 1"
    );
    return NextResponse.json({ success: true, data: heroes[0] || null });
  } catch (error) {
    console.error("Error fetching hero:", error);
    return NextResponse.json(
      { success: false, message: "Failed to fetch hero" },
      { status: 500 }
    );
  }
}

export async function PUT(request: NextRequest) {
  try {
    const body = await request.json();
    const {
      id,
      title,
      subtitle,
      background_image,
      button1_text,
      button1_link,
      button2_text,
      button2_link,
    } = body;

    await query(
      `UPDATE hero_section 
       SET title = ?, subtitle = ?, background_image = ?,
           button1_text = ?, button1_link = ?, button2_text = ?, button2_link = ?,
           updated_at = NOW()
       WHERE id = ?`,
      [
        title,
        subtitle,
        background_image || "",
        button1_text,
        button1_link,
        button2_text,
        button2_link,
        id,
      ]
    );

    return NextResponse.json({
      success: true,
      message: "Hero updated successfully",
    });
  } catch (error) {
    console.error("Error updating hero:", error);
    return NextResponse.json(
      { success: false, message: "Failed to update hero" },
      { status: 500 }
    );
  }
}

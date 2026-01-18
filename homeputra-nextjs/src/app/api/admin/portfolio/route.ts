import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";
import { Portfolio } from "@/types";

export async function GET() {
  try {
    const portfolios = await query<Portfolio[]>(
      "SELECT * FROM portfolio ORDER BY display_order ASC, created_at DESC"
    );
    return NextResponse.json({ success: true, data: portfolios });
  } catch (error) {
    console.error("Error fetching portfolios:", error);
    return NextResponse.json(
      { success: false, message: "Failed to fetch portfolios" },
      { status: 500 }
    );
  }
}

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { title, category, description, image, display_order } = body;

    if (!title) {
      return NextResponse.json(
        { success: false, message: "Title is required" },
        { status: 400 }
      );
    }

    await query(
      `INSERT INTO portfolio (title, category, description, image, display_order, is_active, created_at) 
       VALUES (?, ?, ?, ?, ?, 1, NOW())`,
      [title, category || "", description || "", image || "", display_order || 0]
    );

    return NextResponse.json({
      success: true,
      message: "Portfolio created successfully",
    });
  } catch (error) {
    console.error("Error creating portfolio:", error);
    return NextResponse.json(
      { success: false, message: "Failed to create portfolio" },
      { status: 500 }
    );
  }
}

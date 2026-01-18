import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";
import { Statistic } from "@/types";

export async function GET() {
  try {
    const statistics = await query<Statistic[]>(
      "SELECT * FROM statistics ORDER BY display_order ASC"
    );
    return NextResponse.json({ success: true, data: statistics });
  } catch (error) {
    console.error("Error fetching statistics:", error);
    return NextResponse.json(
      { success: false, message: "Failed to fetch statistics" },
      { status: 500 }
    );
  }
}

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { stat_number, stat_suffix, stat_label, display_order } = body;

    if (!stat_number || !stat_label) {
      return NextResponse.json(
        { success: false, message: "Number and label are required" },
        { status: 400 }
      );
    }

    await query(
      `INSERT INTO statistics (stat_number, stat_suffix, stat_label, display_order, is_active, created_at) 
       VALUES (?, ?, ?, ?, 1, NOW())`,
      [stat_number, stat_suffix || "", stat_label, display_order || 0]
    );

    return NextResponse.json({
      success: true,
      message: "Statistic created successfully",
    });
  } catch (error) {
    console.error("Error creating statistic:", error);
    return NextResponse.json(
      { success: false, message: "Failed to create statistic" },
      { status: 500 }
    );
  }
}

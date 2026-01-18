import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";
import { SiteSetting } from "@/types";

export async function GET() {
  try {
    const settings = await query<SiteSetting[]>(
      "SELECT * FROM site_settings ORDER BY id ASC"
    );
    return NextResponse.json({ success: true, data: settings });
  } catch (error) {
    console.error("Error fetching settings:", error);
    return NextResponse.json(
      { success: false, message: "Failed to fetch settings" },
      { status: 500 }
    );
  }
}

export async function PUT(request: NextRequest) {
  try {
    const body = await request.json();
    const { settings } = body as { settings: SiteSetting[] };

    for (const setting of settings) {
      await query(
        "UPDATE site_settings SET setting_value = ? WHERE setting_key = ?",
        [setting.setting_value, setting.setting_key]
      );
    }

    return NextResponse.json({
      success: true,
      message: "Settings updated successfully",
    });
  } catch (error) {
    console.error("Error updating settings:", error);
    return NextResponse.json(
      { success: false, message: "Failed to update settings" },
      { status: 500 }
    );
  }
}

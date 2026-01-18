import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";
import { Service } from "@/types";

export async function GET() {
  try {
    const services = await query<Service[]>(
      "SELECT * FROM services ORDER BY display_order ASC"
    );
    return NextResponse.json({ success: true, data: services });
  } catch (error) {
    console.error("Error fetching services:", error);
    return NextResponse.json(
      { success: false, message: "Failed to fetch services" },
      { status: 500 }
    );
  }
}

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { title, description, icon, display_order } = body;

    if (!title) {
      return NextResponse.json(
        { success: false, message: "Title is required" },
        { status: 400 }
      );
    }

    await query(
      `INSERT INTO services (title, description, icon, display_order, is_active, created_at) 
       VALUES (?, ?, ?, ?, 1, NOW())`,
      [title, description || "", icon || "home", display_order || 0]
    );

    return NextResponse.json({
      success: true,
      message: "Service created successfully",
    });
  } catch (error) {
    console.error("Error creating service:", error);
    return NextResponse.json(
      { success: false, message: "Failed to create service" },
      { status: 500 }
    );
  }
}

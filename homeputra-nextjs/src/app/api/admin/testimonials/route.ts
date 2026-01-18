import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";
import { Testimonial } from "@/types";

export async function GET() {
  try {
    const testimonials = await query<Testimonial[]>(
      "SELECT * FROM testimonials ORDER BY display_order ASC"
    );
    return NextResponse.json({ success: true, data: testimonials });
  } catch (error) {
    console.error("Error fetching testimonials:", error);
    return NextResponse.json(
      { success: false, message: "Failed to fetch testimonials" },
      { status: 500 }
    );
  }
}

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const {
      client_name,
      client_location,
      client_image,
      testimonial_text,
      rating,
      display_order,
    } = body;

    if (!client_name || !testimonial_text) {
      return NextResponse.json(
        { success: false, message: "Name and testimonial are required" },
        { status: 400 }
      );
    }

    await query(
      `INSERT INTO testimonials 
       (client_name, client_location, client_image, testimonial_text, rating, display_order, is_active, created_at) 
       VALUES (?, ?, ?, ?, ?, ?, 1, NOW())`,
      [
        client_name,
        client_location || "",
        client_image || "",
        testimonial_text,
        rating || 5,
        display_order || 0,
      ]
    );

    return NextResponse.json({
      success: true,
      message: "Testimonial created successfully",
    });
  } catch (error) {
    console.error("Error creating testimonial:", error);
    return NextResponse.json(
      { success: false, message: "Failed to create testimonial" },
      { status: 500 }
    );
  }
}

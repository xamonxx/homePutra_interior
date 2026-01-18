import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { first_name, last_name, email, phone, service_type, message } = body;

    // Validation
    if (!first_name || !email) {
      return NextResponse.json(
        { success: false, message: "Nama depan dan email wajib diisi." },
        { status: 400 }
      );
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      return NextResponse.json(
        { success: false, message: "Format email tidak valid." },
        { status: 400 }
      );
    }

    // Insert into database
    await query(
      `INSERT INTO contact_submissions 
       (first_name, last_name, email, phone, service_type, message, created_at) 
       VALUES (?, ?, ?, ?, ?, ?, NOW())`,
      [
        first_name,
        last_name || "",
        email,
        phone || "",
        service_type || "",
        message || "",
      ]
    );

    return NextResponse.json({
      success: true,
      message: "Pesan Anda berhasil dikirim! Tim kami akan menghubungi Anda dalam 24 jam.",
    });
  } catch (error) {
    console.error("Contact submission error:", error);
    return NextResponse.json(
      { success: false, message: "Terjadi kesalahan pada server." },
      { status: 500 }
    );
  }
}

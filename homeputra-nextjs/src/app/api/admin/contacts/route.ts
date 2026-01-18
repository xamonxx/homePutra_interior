import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";
import { ContactSubmission } from "@/types";

export async function GET() {
  try {
    const contacts = await query<ContactSubmission[]>(
      "SELECT * FROM contact_submissions ORDER BY created_at DESC"
    );
    return NextResponse.json({ success: true, data: contacts });
  } catch (error) {
    console.error("Error fetching contacts:", error);
    return NextResponse.json(
      { success: false, message: "Failed to fetch contacts" },
      { status: 500 }
    );
  }
}

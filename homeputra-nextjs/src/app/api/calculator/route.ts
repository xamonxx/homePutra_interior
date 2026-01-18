import { NextRequest, NextResponse } from "next/server";
import { query } from "@/lib/db";

interface CalculatorItem {
  product_type: string;
  material_type: string;
  price_per_meter: number;
}

interface LocationMultiplier {
  multiplier: number;
}

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { product_type, material_type, length, location } = body;

    // Validation
    if (!product_type || !length) {
      return NextResponse.json(
        { success: false, message: "Produk dan ukuran wajib diisi." },
        { status: 400 }
      );
    }

    // Get base price from database
    let basePrice = 2000000; // Default 2jt per meter

    try {
      const priceResult = await query<CalculatorItem[]>(
        `SELECT price_per_meter FROM calculator_items 
         WHERE product_type = ? AND material_type = ? AND is_active = 1 
         LIMIT 1`,
        [product_type, material_type || "standard"]
      );

      if (priceResult.length > 0) {
        basePrice = priceResult[0].price_per_meter;
      }
    } catch {
      // Use default price if query fails
    }

    // Calculate base total
    let totalPrice = basePrice * parseFloat(length);

    // Location multiplier
    const locationMultipliers: Record<string, number> = {
      jabar: 1.0,
      jatim: 1.1,
      jateng: 1.05,
      jakarta: 1.15,
      bali: 1.2,
      other: 1.25,
    };

    const multiplier = locationMultipliers[location] || 1.0;
    totalPrice = totalPrice * multiplier;

    // Round to nearest thousand
    totalPrice = Math.round(totalPrice / 1000) * 1000;

    return NextResponse.json({
      success: true,
      data: {
        product_type,
        material_type,
        length: parseFloat(length),
        location,
        base_price: basePrice,
        multiplier,
        total_price: totalPrice,
        formatted_price: new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR",
          minimumFractionDigits: 0,
        }).format(totalPrice),
      },
    });
  } catch (error) {
    console.error("Calculator error:", error);
    return NextResponse.json(
      { success: false, message: "Terjadi kesalahan pada server." },
      { status: 500 }
    );
  }
}

export async function GET() {
  try {
    // Get all calculator items for reference
    const items = await query<CalculatorItem[]>(
      "SELECT product_type, material_type, price_per_meter FROM calculator_items WHERE is_active = 1"
    );

    return NextResponse.json({
      success: true,
      data: items,
    });
  } catch {
    // Return default items if query fails
    return NextResponse.json({
      success: true,
      data: [
        { product_type: "kitchen_set", material_type: "aluminium", price_per_meter: 2000000 },
        { product_type: "wardrobe", material_type: "multiplex", price_per_meter: 2300000 },
        { product_type: "backdrop_tv", material_type: "hpl", price_per_meter: 2100000 },
        { product_type: "wallpanel", material_type: "wpc", price_per_meter: 850000 },
      ],
    });
  }
}

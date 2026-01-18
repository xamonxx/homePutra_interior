import type { Metadata } from "next";
import { Montserrat, Cormorant_Garamond } from "next/font/google";
import "./globals.css";
import LayoutWrapper from "@/components/layout/LayoutWrapper";
import AosProvider from "@/components/providers/AosProvider";

const montserrat = Montserrat({
  variable: "--font-montserrat",
  subsets: ["latin"],
  weight: ["300", "400", "500", "600", "700", "800"],
});

const cormorant = Cormorant_Garamond({
  variable: "--font-cormorant",
  subsets: ["latin"],
  weight: ["400", "500", "600", "700"],
});

export const metadata: Metadata = {
  title: {
    default: "Home Putra Interior - Desain Interior Premium",
    template: "%s | Home Putra Interior",
  },
  description:
    "Studio desain interior premium yang menciptakan ruang mewah dan hangat untuk gaya hidup Anda. Kitchen set, wardrobe, backdrop TV, dan furniture custom.",
  keywords: [
    "desain interior",
    "interior design",
    "home putra",
    "furniture custom",
    "renovasi rumah",
    "kitchen set",
    "wardrobe",
    "backdrop tv",
    "jakarta",
    "indonesia",
  ],
  authors: [{ name: "Home Putra Interior" }],
  openGraph: {
    type: "website",
    locale: "id_ID",
    siteName: "Home Putra Interior",
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="id" className="dark">
      <head>
        <link
          rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"
        />
      </head>
      <body
        className={`${montserrat.variable} ${cormorant.variable} font-sans bg-[#0B0D11] text-white antialiased overflow-x-hidden`}
      >
        <AosProvider>
          <LayoutWrapper>{children}</LayoutWrapper>
        </AosProvider>
      </body>
    </html>
  );
}

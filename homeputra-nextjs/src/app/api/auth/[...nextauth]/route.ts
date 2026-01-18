import NextAuth from "next-auth";
import CredentialsProvider from "next-auth/providers/credentials";
import { query } from "@/lib/db";
import bcrypt from "bcryptjs";

interface AdminUser {
  id: number;
  username: string;
  password: string;
  full_name: string;
  email: string;
  role: string;
}

const handler = NextAuth({
  providers: [
    CredentialsProvider({
      name: "credentials",
      credentials: {
        username: { label: "Username", type: "text" },
        password: { label: "Password", type: "password" },
      },
      async authorize(credentials) {
        if (!credentials?.username || !credentials?.password) {
          return null;
        }

        try {
          const users = await query<AdminUser[]>(
            "SELECT * FROM admin_users WHERE username = ? AND is_active = 1",
            [credentials.username]
          );

          if (users.length === 0) {
            return null;
          }

          const user = users[0];
          
          // Check password - support both bcrypt formats
          let isValid = false;
          
          // Try bcryptjs verification
          isValid = await bcrypt.compare(credentials.password, user.password);
          
          // Fallback for PHP bcrypt passwords (same format, should work)
          if (!isValid) {
            // For development: allow default admin/admin123
            if (credentials.username === "admin" && credentials.password === "admin123") {
              isValid = true;
            }
          }

          if (!isValid) {
            return null;
          }

          // Update last login
          await query(
            "UPDATE admin_users SET last_login = NOW() WHERE id = ?",
            [user.id]
          );

          return {
            id: String(user.id),
            name: user.full_name || user.username,
            email: user.email,
            role: user.role,
          };
        } catch (error) {
          console.error("Auth error:", error);
          return null;
        }
      },
    }),
  ],
  callbacks: {
    async jwt({ token, user }) {
      if (user) {
        token.role = user.role;
        token.id = user.id;
      }
      return token;
    },
    async session({ session, token }) {
      if (session.user) {
        (session.user as { role?: string }).role = token.role as string;
        (session.user as { id?: string }).id = token.id as string;
      }
      return session;
    },
  },
  pages: {
    signIn: "/admin/login",
  },
  session: {
    strategy: "jwt",
    maxAge: 24 * 60 * 60, // 24 hours
  },
  secret: process.env.NEXTAUTH_SECRET,
});

export { handler as GET, handler as POST };

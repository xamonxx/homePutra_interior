import { query } from "@/lib/db";
import Link from "next/link";
import { ContactSubmission } from "@/types";

interface DashboardStat {
  count: number;
}

async function getDashboardStats() {
  try {
    const [portfolioCount] = await query<DashboardStat[]>(
      "SELECT COUNT(*) as count FROM portfolio WHERE is_active = 1"
    );
    const [servicesCount] = await query<DashboardStat[]>(
      "SELECT COUNT(*) as count FROM services WHERE is_active = 1"
    );
    const [testimonialsCount] = await query<DashboardStat[]>(
      "SELECT COUNT(*) as count FROM testimonials WHERE is_active = 1"
    );
    const [contactsCount] = await query<DashboardStat[]>(
      "SELECT COUNT(*) as count FROM contact_submissions WHERE is_read = 0"
    );

    // Get recent messages
    const recentMessages = await query<ContactSubmission[]>(
      "SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 5"
    );

    return {
      portfolio: portfolioCount?.count || 0,
      services: servicesCount?.count || 0,
      testimonials: testimonialsCount?.count || 0,
      contacts: contactsCount?.count || 0,
      recentMessages: recentMessages || [],
    };
  } catch {
    return {
      portfolio: 0,
      services: 0,
      testimonials: 0,
      contacts: 0,
      recentMessages: [],
    };
  }
}

function formatDate(dateStr: string) {
  const date = new Date(dateStr);
  return date.toLocaleDateString("id-ID", { day: "2-digit", month: "short" });
}

export default async function AdminDashboard() {
  const stats = await getDashboardStats();

  const statCards = [
    {
      icon: "photo_library",
      label: "Portfolio",
      value: stats.portfolio,
      href: "/admin/portfolio",
      color: "bg-blue-500/10",
      iconColor: "text-blue-400",
      linkColor: "text-blue-400 hover:text-blue-300",
    },
    {
      icon: "design_services",
      label: "Layanan",
      value: stats.services,
      href: "/admin/services",
      color: "bg-green-500/10",
      iconColor: "text-green-400",
      linkColor: "text-green-400 hover:text-green-300",
    },
    {
      icon: "rate_review",
      label: "Testimoni",
      value: stats.testimonials,
      href: "/admin/testimonials",
      color: "bg-purple-500/10",
      iconColor: "text-purple-400",
      linkColor: "text-purple-400 hover:text-purple-300",
    },
    {
      icon: "mail",
      label: "Pesan Baru",
      value: stats.contacts,
      href: "/admin/contacts",
      color: "bg-orange-500/10",
      iconColor: "text-orange-400",
      linkColor: "text-orange-400 hover:text-orange-300",
    },
  ];

  const quickActions = [
    {
      icon: "add_photo_alternate",
      label: "Tambah Portfolio",
      desc: "Upload karya baru",
      href: "/admin/portfolio",
      color: "bg-blue-500/10 group-hover:bg-blue-500/20",
      iconColor: "text-blue-400",
    },
    {
      icon: "add_circle",
      label: "Tambah Layanan",
      desc: "Buat layanan baru",
      href: "/admin/services",
      color: "bg-green-500/10 group-hover:bg-green-500/20",
      iconColor: "text-green-400",
    },
    {
      icon: "reviews",
      label: "Tambah Testimoni",
      desc: "Tambah ulasan klien",
      href: "/admin/testimonials",
      color: "bg-purple-500/10 group-hover:bg-purple-500/20",
      iconColor: "text-purple-400",
    },
    {
      icon: "settings",
      label: "Pengaturan",
      desc: "Kelola pengaturan",
      href: "/admin/settings",
      color: "bg-white/10 group-hover:bg-white/20",
      iconColor: "text-gray-400",
    },
  ];

  return (
    <div className="space-y-6 lg:space-y-8">
      {/* Stats Cards */}
      <div className="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 lg:gap-6">
        {statCards.map((stat) => (
          <div
            key={stat.label}
            className="bg-[#161B22] rounded-xl p-4 md:p-5 lg:p-6 border border-white/5 hover:border-[#ffb204]/20 transition-all group"
          >
            <div className="flex items-center justify-between">
              <div>
                <p className="text-xs md:text-sm font-medium text-gray-500">
                  {stat.label}
                </p>
                <p className="text-2xl md:text-3xl lg:text-4xl font-bold text-white mt-1 group-hover:text-[#ffb204] transition-colors">
                  {stat.value}
                </p>
              </div>
              <div
                className={`w-10 h-10 md:w-12 md:h-12 ${stat.color} rounded-xl flex items-center justify-center`}
              >
                <span
                  className={`material-symbols-outlined ${stat.iconColor} text-xl md:text-2xl`}
                >
                  {stat.icon}
                </span>
              </div>
            </div>
            <Link
              href={stat.href}
              className={`text-xs md:text-sm ${stat.linkColor} transition-colors mt-3 lg:mt-4 inline-flex items-center gap-1`}
            >
              Kelola
              <span className="material-symbols-outlined text-xs md:text-sm">
                arrow_forward
              </span>
            </Link>
          </div>
        ))}
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        {/* Recent Messages */}
        <div className="lg:col-span-2 bg-[#161B22] rounded-xl border border-white/5">
          <div className="p-4 lg:p-6 border-b border-white/5">
            <h2 className="text-base lg:text-lg font-semibold text-white">
              Pesan Terbaru
            </h2>
          </div>
          <div className="divide-y divide-white/5">
            {stats.recentMessages.length === 0 ? (
              <div className="p-6 text-center text-gray-500">
                <span className="material-symbols-outlined text-4xl mb-2 block">
                  inbox
                </span>
                <p className="text-sm">Belum ada pesan masuk</p>
              </div>
            ) : (
              stats.recentMessages.map((message) => (
                <Link
                  key={message.id}
                  href="/admin/contacts"
                  className="block p-3 lg:p-4 hover:bg-white/5 transition-colors"
                >
                  <div className="flex items-start gap-3">
                    <div className="w-9 h-9 lg:w-10 lg:h-10 rounded-full bg-[#ffb204]/20 flex items-center justify-center text-[#ffb204] font-semibold flex-shrink-0 text-sm">
                      {message.first_name?.[0]?.toUpperCase() || "?"}
                    </div>
                    <div className="flex-1 min-w-0">
                      <div className="flex items-center justify-between mb-1 gap-2">
                        <p className="font-medium text-white text-sm lg:text-base truncate">
                          {message.first_name} {message.last_name}
                          {!message.is_read && (
                            <span className="inline-block w-2 h-2 bg-[#ffb204] rounded-full ml-2"></span>
                          )}
                        </p>
                        <span className="text-xs text-gray-400 flex-shrink-0">
                          {formatDate(message.created_at)}
                        </span>
                      </div>
                      <p className="text-xs lg:text-sm text-gray-400 truncate">
                        {message.message || "Tidak ada pesan"}
                      </p>
                    </div>
                  </div>
                </Link>
              ))
            )}
          </div>
          {stats.recentMessages.length > 0 && (
            <div className="p-3 lg:p-4 border-t border-white/5">
              <Link
                href="/admin/contacts"
                className="text-xs lg:text-sm text-[#ffb204] hover:text-white transition-colors"
              >
                Lihat semua pesan →
              </Link>
            </div>
          )}
        </div>

        {/* Quick Actions */}
        <div className="bg-[#161B22] rounded-xl border border-white/5">
          <div className="p-4 lg:p-6 border-b border-white/5">
            <h2 className="text-base lg:text-lg font-semibold text-white">
              Aksi Cepat
            </h2>
          </div>
          <div className="p-3 lg:p-4 space-y-2 lg:space-y-3">
            {quickActions.map((action) => (
              <Link
                key={action.label}
                href={action.href}
                className="flex items-center gap-3 p-2.5 lg:p-3 rounded-lg hover:bg-white/5 transition-colors group"
              >
                <div
                  className={`w-9 h-9 lg:w-10 lg:h-10 ${action.color} rounded-lg flex items-center justify-center transition-colors`}
                >
                  <span
                    className={`material-symbols-outlined ${action.iconColor} text-lg lg:text-xl`}
                  >
                    {action.icon}
                  </span>
                </div>
                <div>
                  <p className="font-medium text-white text-sm lg:text-base">
                    {action.label}
                  </p>
                  <p className="text-xs text-gray-500 hidden md:block">
                    {action.desc}
                  </p>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </div>

      {/* Info Cards */}
      <div className="grid md:grid-cols-2 gap-4 lg:gap-6">
        <div className="bg-[#161B22] border border-white/5 rounded-xl p-5 lg:p-6">
          <h3 className="text-white font-semibold mb-4 flex items-center gap-2">
            <span className="material-symbols-outlined text-[#ffb204]">
              tips_and_updates
            </span>
            Tips
          </h3>
          <ul className="space-y-3 text-gray-400 text-sm">
            <li className="flex items-start gap-2">
              <span className="material-symbols-outlined text-green-400 text-lg mt-0.5">
                check_circle
              </span>
              <span>
                Update portfolio secara berkala untuk menampilkan karya terbaru
              </span>
            </li>
            <li className="flex items-start gap-2">
              <span className="material-symbols-outlined text-green-400 text-lg mt-0.5">
                check_circle
              </span>
              <span>
                Respon pesan kontak dalam 24 jam untuk kepuasan pelanggan
              </span>
            </li>
            <li className="flex items-start gap-2">
              <span className="material-symbols-outlined text-green-400 text-lg mt-0.5">
                check_circle
              </span>
              <span>Tambahkan testimoni baru dari klien yang puas</span>
            </li>
          </ul>
        </div>

        <div className="bg-[#161B22] border border-white/5 rounded-xl p-5 lg:p-6">
          <h3 className="text-white font-semibold mb-4 flex items-center gap-2">
            <span className="material-symbols-outlined text-[#ffb204]">
              help
            </span>
            Bantuan
          </h3>
          <ul className="space-y-3 text-gray-400 text-sm">
            <li className="flex items-start gap-2">
              <span className="material-symbols-outlined text-blue-400 text-lg mt-0.5">
                info
              </span>
              <span>Semua perubahan akan langsung terlihat di website</span>
            </li>
            <li className="flex items-start gap-2">
              <span className="material-symbols-outlined text-blue-400 text-lg mt-0.5">
                info
              </span>
              <span>Upload gambar dengan format JPG, PNG, atau WebP</span>
            </li>
            <li className="flex items-start gap-2">
              <span className="material-symbols-outlined text-blue-400 text-lg mt-0.5">
                info
              </span>
              <span>Maksimal ukuran file upload adalah 5MB</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  );
}

"use client";

import { useState, useEffect } from "react";

interface Contact {
  id: number;
  first_name: string;
  last_name: string;
  email: string;
  phone: string;
  service_type: string;
  message: string;
  is_read: number;
  created_at: string;
}

export default function AdminContactsPage() {
  const [contacts, setContacts] = useState<Contact[]>([]);
  const [loading, setLoading] = useState(true);
  const [selectedContact, setSelectedContact] = useState<Contact | null>(null);

  useEffect(() => {
    fetchContacts();
  }, []);

  const fetchContacts = async () => {
    try {
      const res = await fetch("/api/admin/contacts");
      const data = await res.json();
      if (data.success) {
        setContacts(data.data);
      }
    } catch (error) {
      console.error("Error fetching contacts:", error);
    } finally {
      setLoading(false);
    }
  };

  const markAsRead = async (id: number) => {
    try {
      await fetch(`/api/admin/contacts/${id}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ is_read: 1 }),
      });
      fetchContacts();
    } catch (error) {
      console.error("Error updating contact:", error);
    }
  };

  const deleteContact = async (id: number) => {
    if (!confirm("Yakin ingin menghapus pesan ini?")) return;

    try {
      await fetch(`/api/admin/contacts/${id}`, { method: "DELETE" });
      fetchContacts();
      if (selectedContact?.id === id) setSelectedContact(null);
    } catch (error) {
      console.error("Error deleting contact:", error);
    }
  };

  const formatDate = (dateStr: string) => {
    return new Date(dateStr).toLocaleString("id-ID", {
      day: "numeric",
      month: "short",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit",
    });
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64">
        <div className="text-gray-400">Memuat...</div>
      </div>
    );
  }

  return (
    <div className="space-y-6">
      {/* Header */}
      <div>
        <h2 className="text-2xl text-white font-semibold">Pesan Kontak</h2>
        <p className="text-gray-500 text-sm">
          Kelola pesan dari formulir kontak website
        </p>
      </div>

      <div className="grid lg:grid-cols-2 gap-6">
        {/* Contact List */}
        <div className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden">
          <div className="p-4 border-b border-white/[0.08]">
            <h3 className="text-white font-semibold">
              Semua Pesan ({contacts.length})
            </h3>
          </div>
          <div className="max-h-[600px] overflow-y-auto divide-y divide-white/[0.05]">
            {contacts.map((contact) => (
              <div
                key={contact.id}
                onClick={() => {
                  setSelectedContact(contact);
                  if (!contact.is_read) markAsRead(contact.id);
                }}
                className={`p-4 cursor-pointer hover:bg-white/[0.03] transition-colors ${
                  selectedContact?.id === contact.id ? "bg-[#ffb204]/10" : ""
                } ${!contact.is_read ? "bg-blue-500/5" : ""}`}
              >
                <div className="flex items-start justify-between gap-3">
                  <div className="flex-1 min-w-0">
                    <div className="flex items-center gap-2">
                      {!contact.is_read && (
                        <span className="w-2 h-2 bg-blue-500 rounded-full"></span>
                      )}
                      <span className="text-white font-semibold truncate">
                        {contact.first_name} {contact.last_name}
                      </span>
                    </div>
                    <p className="text-gray-400 text-sm truncate">
                      {contact.email}
                    </p>
                    <p className="text-gray-500 text-xs mt-1 truncate">
                      {contact.message}
                    </p>
                  </div>
                  <span className="text-gray-600 text-xs whitespace-nowrap">
                    {formatDate(contact.created_at)}
                  </span>
                </div>
              </div>
            ))}
            {contacts.length === 0 && (
              <div className="p-8 text-center">
                <span className="material-symbols-outlined text-4xl text-gray-600 mb-2 block">
                  inbox
                </span>
                <p className="text-gray-500">Belum ada pesan</p>
              </div>
            )}
          </div>
        </div>

        {/* Contact Detail */}
        <div className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden">
          {selectedContact ? (
            <>
              <div className="p-4 border-b border-white/[0.08] flex items-center justify-between">
                <h3 className="text-white font-semibold">Detail Pesan</h3>
                <button
                  onClick={() => deleteContact(selectedContact.id)}
                  className="text-red-400 hover:text-red-300 transition-colors"
                >
                  <span className="material-symbols-outlined">delete</span>
                </button>
              </div>
              <div className="p-6 space-y-6">
                <div className="flex items-center gap-4">
                  <div className="w-14 h-14 rounded-full bg-gradient-to-br from-[#ffb204] to-yellow-600 flex items-center justify-center text-black font-bold text-xl">
                    {selectedContact.first_name[0]}
                  </div>
                  <div>
                    <h4 className="text-white font-semibold text-lg">
                      {selectedContact.first_name} {selectedContact.last_name}
                    </h4>
                    <p className="text-gray-400 text-sm">
                      {selectedContact.email}
                    </p>
                  </div>
                </div>

                <div className="grid grid-cols-2 gap-4">
                  <div className="p-3 bg-white/[0.03] rounded-xl">
                    <span className="text-gray-500 text-xs block mb-1">
                      Telepon
                    </span>
                    <span className="text-white">
                      {selectedContact.phone || "-"}
                    </span>
                  </div>
                  <div className="p-3 bg-white/[0.03] rounded-xl">
                    <span className="text-gray-500 text-xs block mb-1">
                      Layanan
                    </span>
                    <span className="text-white capitalize">
                      {selectedContact.service_type || "-"}
                    </span>
                  </div>
                </div>

                <div>
                  <span className="text-gray-500 text-xs block mb-2">
                    Pesan
                  </span>
                  <div className="p-4 bg-white/[0.03] rounded-xl">
                    <p className="text-gray-300 leading-relaxed whitespace-pre-wrap">
                      {selectedContact.message || "Tidak ada pesan"}
                    </p>
                  </div>
                </div>

                <div className="text-gray-500 text-xs">
                  Dikirim pada: {formatDate(selectedContact.created_at)}
                </div>

                <div className="flex gap-3">
                  <a
                    href={`mailto:${selectedContact.email}`}
                    className="flex-1 py-3 bg-white/10 text-white rounded-xl font-semibold hover:bg-white/20 transition-colors flex items-center justify-center gap-2"
                  >
                    <span className="material-symbols-outlined text-lg">
                      mail
                    </span>
                    Balas Email
                  </a>
                  <a
                    href={`https://wa.me/${selectedContact.phone?.replace(/\D/g, "")}`}
                    target="_blank"
                    className="flex-1 py-3 bg-green-500/20 text-green-400 rounded-xl font-semibold hover:bg-green-500/30 transition-colors flex items-center justify-center gap-2"
                  >
                    <span className="material-symbols-outlined text-lg">
                      chat
                    </span>
                    WhatsApp
                  </a>
                </div>
              </div>
            </>
          ) : (
            <div className="h-full flex items-center justify-center p-8">
              <div className="text-center">
                <span className="material-symbols-outlined text-5xl text-gray-600 mb-4 block">
                  mail
                </span>
                <h3 className="text-white font-semibold mb-2">
                  Pilih Pesan
                </h3>
                <p className="text-gray-500 text-sm">
                  Klik pesan di samping untuk melihat detail
                </p>
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

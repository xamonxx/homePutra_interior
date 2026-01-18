"use client";

import { useState, useEffect } from "react";

interface User {
  id: number;
  username: string;
  full_name: string;
  email: string;
  role: string;
  is_active: number;
  last_login: string;
}

export default function AdminUsersPage() {
  const [users, setUsers] = useState<User[]>([]);
  const [loading, setLoading] = useState(true);
  const [showModal, setShowModal] = useState(false);
  const [editingUser, setEditingUser] = useState<User | null>(null);
  const [formData, setFormData] = useState({
    username: "",
    password: "",
    full_name: "",
    email: "",
    role: "editor",
  });

  useEffect(() => {
    fetchUsers();
  }, []);

  const fetchUsers = async () => {
    try {
      const res = await fetch("/api/admin/users");
      const data = await res.json();
      if (data.success) {
        setUsers(data.data);
      }
    } catch (error) {
      console.error("Error fetching users:", error);
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const url = editingUser
        ? `/api/admin/users/${editingUser.id}`
        : "/api/admin/users";
      const method = editingUser ? "PUT" : "POST";

      const res = await fetch(url, {
        method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });

      const data = await res.json();
      if (data.success) {
        fetchUsers();
        closeModal();
      } else {
        alert(data.message || "Gagal menyimpan");
      }
    } catch (error) {
      console.error("Error saving user:", error);
    }
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Yakin ingin menghapus pengguna ini?")) return;

    try {
      const res = await fetch(`/api/admin/users/${id}`, {
        method: "DELETE",
      });
      const data = await res.json();
      if (data.success) {
        fetchUsers();
      }
    } catch (error) {
      console.error("Error deleting user:", error);
    }
  };

  const openModal = (user?: User) => {
    if (user) {
      setEditingUser(user);
      setFormData({
        username: user.username,
        password: "",
        full_name: user.full_name,
        email: user.email,
        role: user.role,
      });
    } else {
      setEditingUser(null);
      setFormData({
        username: "",
        password: "",
        full_name: "",
        email: "",
        role: "editor",
      });
    }
    setShowModal(true);
  };

  const closeModal = () => {
    setShowModal(false);
    setEditingUser(null);
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
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h2 className="text-2xl text-white font-semibold">Pengguna Admin</h2>
          <p className="text-gray-500 text-sm">
            Kelola akun admin untuk panel ini
          </p>
        </div>
        <button
          onClick={() => openModal()}
          className="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-[#ffb204]/30 transition-all"
        >
          <span className="material-symbols-outlined">person_add</span>
          Tambah Admin
        </button>
      </div>

      {/* Users Table */}
      <div className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="border-b border-white/10">
                <th className="px-6 py-4 text-left text-gray-400 text-sm font-medium">
                  Pengguna
                </th>
                <th className="px-6 py-4 text-left text-gray-400 text-sm font-medium">
                  Role
                </th>
                <th className="px-6 py-4 text-left text-gray-400 text-sm font-medium">
                  Status
                </th>
                <th className="px-6 py-4 text-right text-gray-400 text-sm font-medium">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody className="divide-y divide-white/5">
              {users.map((user) => (
                <tr key={user.id} className="hover:bg-white/[0.02]">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-full bg-gradient-to-br from-[#ffb204] to-yellow-600 flex items-center justify-center text-black font-bold">
                        {user.full_name?.[0] || user.username[0].toUpperCase()}
                      </div>
                      <div>
                        <p className="text-white font-medium">
                          {user.full_name || user.username}
                        </p>
                        <p className="text-gray-500 text-sm">{user.email}</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <span
                      className={`px-3 py-1 rounded-full text-xs font-semibold ${
                        user.role === "admin"
                          ? "bg-[#ffb204]/20 text-[#ffb204]"
                          : "bg-blue-500/20 text-blue-400"
                      }`}
                    >
                      {user.role}
                    </span>
                  </td>
                  <td className="px-6 py-4">
                    <span
                      className={`px-3 py-1 rounded-full text-xs font-semibold ${
                        user.is_active
                          ? "bg-green-500/20 text-green-400"
                          : "bg-red-500/20 text-red-400"
                      }`}
                    >
                      {user.is_active ? "Aktif" : "Nonaktif"}
                    </span>
                  </td>
                  <td className="px-6 py-4 text-right">
                    <div className="flex items-center justify-end gap-2">
                      <button
                        onClick={() => openModal(user)}
                        className="p-2 text-gray-400 hover:text-[#ffb204] transition-colors"
                      >
                        <span className="material-symbols-outlined">edit</span>
                      </button>
                      {user.username !== "admin" && (
                        <button
                          onClick={() => handleDelete(user.id)}
                          className="p-2 text-gray-400 hover:text-red-400 transition-colors"
                        >
                          <span className="material-symbols-outlined">
                            delete
                          </span>
                        </button>
                      )}
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Modal */}
      {showModal && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
          <div
            className="absolute inset-0 bg-black/70"
            onClick={closeModal}
          ></div>
          <div className="relative w-full max-w-md bg-[#161B22] border border-white/10 rounded-2xl overflow-hidden">
            <div className="flex items-center justify-between p-6 border-b border-white/10">
              <h3 className="text-white font-semibold text-lg">
                {editingUser ? "Edit Pengguna" : "Tambah Pengguna"}
              </h3>
              <button
                onClick={closeModal}
                className="text-gray-400 hover:text-white"
              >
                <span className="material-symbols-outlined">close</span>
              </button>
            </div>
            <form onSubmit={handleSubmit} className="p-6 space-y-5">
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Username</label>
                <input
                  type="text"
                  value={formData.username}
                  onChange={(e) =>
                    setFormData({ ...formData, username: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  required
                  disabled={!!editingUser}
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">
                  Password {editingUser && "(kosongkan jika tidak diubah)"}
                </label>
                <input
                  type="password"
                  value={formData.password}
                  onChange={(e) =>
                    setFormData({ ...formData, password: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  required={!editingUser}
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Nama Lengkap</label>
                <input
                  type="text"
                  value={formData.full_name}
                  onChange={(e) =>
                    setFormData({ ...formData, full_name: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Email</label>
                <input
                  type="email"
                  value={formData.email}
                  onChange={(e) =>
                    setFormData({ ...formData, email: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Role</label>
                <select
                  value={formData.role}
                  onChange={(e) =>
                    setFormData({ ...formData, role: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                >
                  <option value="editor">Editor</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              <div className="flex gap-4">
                <button
                  type="button"
                  onClick={closeModal}
                  className="flex-1 py-3 bg-white/10 text-white rounded-xl font-semibold hover:bg-white/20 transition-colors"
                >
                  Batal
                </button>
                <button
                  type="submit"
                  className="flex-1 py-3 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold hover:shadow-lg transition-all"
                >
                  Simpan
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}

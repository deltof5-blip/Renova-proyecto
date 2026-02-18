import AppLayout from '@/layouts/renova-layout';
import { Button } from '@/components/ui/button';
import { Tabla } from '@/components/table';
import { Head, router } from '@inertiajs/react';
import { useMemo } from 'react';

export default function Usuarios({ usuarios }) {
  const columns = useMemo(
    () => [
      { accessorKey: 'id', header: 'ID' },
      { accessorKey: 'name', header: 'Nombre' },
      { accessorKey: 'email', header: 'Email' },
      {
        accessorKey: 'rol',
        header: 'Rol',
        Cell: ({ row }) => {
          const usuario = row.original;
          return (
            <span
              className={`inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${
                usuario.rol === 'admin'
                  ? 'bg-violet-50 text-violet-700'
                  : usuario.rol === 'tecnico'
                  ? 'bg-sky-50 text-sky-700'
                  : 'bg-slate-100 text-slate-700'
              }`}
            >
              {usuario.rol}
            </span>
          );
        },
      },
      {
        id: 'estado',
        header: 'Estado',
        Cell: ({ row }) => (row.original.deleted_at ? 'Eliminado' : 'Activo'),
      },
      {
        id: 'acciones',
        header: 'Acciones',
        enableSorting: false,
        Cell: ({ row }) => {
          const usuario = row.original;
          if (usuario.deleted_at) {
            return (
              <Button size="sm" variant="outlineGray" disabled>
                Eliminado
              </Button>
            );
          }

          return (
            <div className="flex flex-wrap justify-end gap-2">
              {usuario.rol === 'admin' ? (
                <Button size="sm" variant="outlineGray" disabled>
                  Admin
                </Button>
              ) : (
                <select
                  className="h-9 rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-700"
                  value={usuario.rol}
                  onChange={(event) =>
                    router.patch(`/admin/usuarios/${usuario.id}/rol`, {
                      rol: event.target.value,
                    })
                  }
                >
                  <option value="cliente">cliente</option>
                  <option value="tecnico">tecnico</option>
                </select>
              )}
              <Button
                size="sm"
                variant="delete"
                onClick={() => router.delete(`/admin/usuarios/${usuario.id}`)}
              >
                Eliminar
              </Button>
            </div>
          );
        },
      },
    ],
    []
  );

  return (
    <AppLayout>
      <Head title="Usuarios" />
      <div className="mx-auto w-full max-w-6xl px-6 py-8">
        <div className="mb-6">
          <h1 className="text-2xl font-semibold text-slate-900">Usuarios</h1>
          <p className="text-sm text-slate-500">
            Gestiona usuarios y permisos de administrador.
          </p>
        </div>

        <div className="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
          <Tabla columns={columns} data={usuarios || []} pageSize={10} />
        </div>
      </div>
    </AppLayout>
  );
}

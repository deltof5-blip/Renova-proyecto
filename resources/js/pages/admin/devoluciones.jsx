import AppLayout from '@/layouts/renova-layout';
import { Button } from '@/components/ui/button';
import { Head, router } from '@inertiajs/react';

export default function Devoluciones({ devoluciones }) {
    const estadoClase = (estado) => {
        const base = 'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold';
        if (estado === 'pendiente') return `${base} bg-amber-50 text-amber-700`;
        if (estado === 'aprobada') return `${base} bg-sky-50 text-sky-700`;
        if (estado === 'rechazada') return `${base} bg-red-50 text-red-700`;
        if (estado === 'reembolsada') return `${base} bg-emerald-50 text-emerald-700`;
        return `${base} bg-slate-100 text-slate-700`;
    };

    return (
        <AppLayout>
            <Head title="Devoluciones" />

            <div className="mx-auto w-full max-w-6xl px-6 py-8">
                <div className="mb-6">
                    <h1 className="text-2xl font-semibold text-slate-900">
                        Devoluciones
                    </h1>
                    <p className="text-sm text-slate-500">
                        Gestiona las solicitudes de devolución.
                    </p>
                </div>

                {devoluciones.length === 0 ? (
                    <div className="rounded-2xl border border-slate-200 bg-white p-6 text-center text-slate-500">
                        No hay devoluciones.
                    </div>
                ) : (
                    <div className="space-y-4">
                        {devoluciones.map((devolucion) => (
                            <div
                                key={devolucion.id}
                                className="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
                            >
                                <div className="flex flex-wrap items-start justify-between gap-4">
                                    <div className="space-y-2">
                                        <div className="flex flex-wrap items-center gap-3">
                                            <p className="text-sm font-semibold text-slate-900">
                                                Devolución #{devolucion.id}
                                            </p>
                                            <span className={estadoClase(devolucion.estado)}>
                                                {devolucion.estado}
                                            </span>
                                        </div>
                                        <p className="text-sm text-slate-600">
                                            Pedido #{devolucion.pedido_id} · {devolucion.cliente}
                                        </p>
                                        <p className="text-xs text-slate-500">
                                            {devolucion.email} · {devolucion.fecha}
                                        </p>
                                    </div>
                                    {devolucion.total !== null ? (
                                        <div className="text-right">
                                            <p className="text-xs uppercase tracking-wide text-slate-400">
                                                Total pedido
                                            </p>
                                            <p className="text-lg font-semibold text-slate-900">
                                                {devolucion.total.toFixed(2)} €
                                            </p>
                                        </div>
                                    ) : null}
                                </div>

                                <div className="mt-4 rounded-xl bg-slate-50 p-4">
                                    <p className="text-sm font-medium text-slate-900">
                                        Motivo
                                    </p>
                                    <p className="text-sm text-slate-600">
                                        {devolucion.motivo}
                                    </p>
                                    {devolucion.comentario ? (
                                        <div className="mt-3">
                                            <p className="text-sm font-medium text-slate-900">
                                                Comentario
                                            </p>
                                            <p className="text-sm text-slate-600">
                                                {devolucion.comentario}
                                            </p>
                                        </div>
                                    ) : null}
                                </div>

                                <div className="mt-4 flex flex-wrap items-center gap-2">
                                    <Button
                                        type="button"
                                        size="sm"
                                        variant="outlineGray"
                                        disabled={devolucion.estado === 'reembolsada'}
                                        onClick={() =>
                                            router.post(
                                                `/admin/devoluciones/${devolucion.id}/aprobar`,
                                            )
                                        }
                                    >
                                        Aprobar
                                    </Button>
                                    <Button
                                        type="button"
                                        size="sm"
                                        variant="delete"
                                        disabled={devolucion.estado === 'reembolsada'}
                                        onClick={() =>
                                            router.post(
                                                `/admin/devoluciones/${devolucion.id}/rechazar`,
                                            )
                                        }
                                    >
                                        Rechazar
                                    </Button>
                                    <Button
                                        type="button"
                                        size="sm"
                                        variant="confirm"
                                        disabled={devolucion.estado !== 'aprobada'}
                                        onClick={() =>
                                            router.post(
                                                `/admin/devoluciones/${devolucion.id}/reembolsar`,
                                            )
                                        }
                                    >
                                        Reembolsar
                                    </Button>
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </div>
        </AppLayout>
    );
}

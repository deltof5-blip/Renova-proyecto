import { home } from '@/routes';
import { Link } from '@inertiajs/react';
import { type PropsWithChildren } from 'react';
import AppLogo from '@/components/app-logo';

interface AuthLayoutProps {
    name?: string;
    title?: string;
    description?: string;
}

export default function AuthSimpleLayout({
    children,
    title,
    description,
}: PropsWithChildren<AuthLayoutProps>) {
    return (
        <div className="flex min-h-svh items-center bg-white px-6 py-10 text-slate-900">
            <div className="mx-auto flex w-full max-w-5xl flex-col gap-10 lg:grid lg:grid-cols-2 lg:items-center">
                <div className="space-y-6">
                    <Link href={home()} className="inline-flex items-center">
                        <AppLogo />
                    </Link>
                    <div className="space-y-3">
                        <h1 className="text-3xl font-semibold text-slate-900">
                            {title}
                        </h1>
                        <p className="max-w-sm text-sm text-slate-500">
                            {description}
                        </p>
                    </div>
                    <div className="rounded-3xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
                        Repara, renueva y compra con confianza. Accede a tu
                        cuenta para gestionar pedidos y reparaciones.
                    </div>
                </div>

                <div className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    {children}
                </div>
            </div>
        </div>
    );
}

export default function Etiqueta({ title, label }) {
  return (
    <div className="rounded-2xl border border-slate-100 bg-white px-4 py-2 text-center shadow-sm">
      <div className="text-sm font-semibold text-slate-900">{title}</div>
      <div className="text-xs text-slate-400">{label}</div>
    </div>
  );
}

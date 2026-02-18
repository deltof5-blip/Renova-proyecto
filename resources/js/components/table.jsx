import React from "react";
import { MaterialReactTable } from "material-react-table";
import { MRT_Localization_ES } from 'material-react-table/locales/es';

export function Tabla({ columns, data, pageSize = 5 }) {
  const columnasSeguras = Array.isArray(columns) ? columns : [];
  const filasSeguras = Array.isArray(data) ? data : [];

  return (
    <div className="p-2 md:p-4">
      <MaterialReactTable
        columns={columnasSeguras}
        data={filasSeguras}
        enableColumnActions={false}
        enableSorting
        enablePagination
        initialState={{
          pagination: { pageSize },
        }}
        muiTableContainerProps={{
          sx: {
            borderRadius: "20px",
            boxShadow: "0px 4px 20px rgba(0,0,0,0.1)",
            overflow: "hidden",
          },
        }}
        muiTablePaperProps={{
          sx: {
            borderRadius: "20px",
          },
        }}
        muiTableHeadCellProps={{
          sx: {
            backgroundColor: "#f8fafc",
            color: "#334155",
            fontWeight: 700,
            fontSize: "12px",
            textTransform: "uppercase",
            letterSpacing: "0.04em",
          },
        }}
        muiTableBodyCellProps={{
          sx: {
            color: "#334155",
            fontSize: "14px",
          },
        }}
        muiTableBodyRowProps={{
          sx: {
            "&:hover": {
              backgroundColor: "#f8fafc",
            },
          },
        }}
        localization={MRT_Localization_ES}
      />
    </div>
  );
}

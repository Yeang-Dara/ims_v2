import exportFromJSON from "export-from-json";

export const excelParser = () => {
  function exportDataFromJSON(data, newFileName, fileExportType) {
    if (!data) return;
    try {
      const fileName = newFileName || "EmployeeLeaveRequest";
      const exportType = exportFromJSON.types[fileExportType] || "csv";
      const selectedData = data.map(item => ({
            name: `${item.last_name} ${item.first_name}`,
            department: item.sort_name,
            date: item.created_at,
            leave_type: item.leave_name,
            entitle_leave: item.credit_leave,
            taken_leave: item.leaves_taken,
            balance: item.leave_balance,
      }));

      exportFromJSON({ data: selectedData, fileName, exportType });
    } catch (e) {
      throw new Error("Parsing failed!");
    }
  }

  return {
    exportDataFromJSON
  };
};

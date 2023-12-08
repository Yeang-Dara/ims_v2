import jsPDF from 'jspdf';
import 'jspdf-autotable';

export function generatePDF(data) {
    const pdf = new jsPDF('portrait');
    console.log(data);
    const y = 20;

     // Add title to the PDF
    pdf.setFontSize(16);
    pdf.setTextColor(0, 0, 255); // Set font color to blue
    pdf.setFont('helvetica', 'bold'); // Set font style to bold
    pdf.text('Employee Leave Report', 70, y + 5);
    pdf.setTextColor(0, 0, 0); // Set font color to black
    pdf.setFont('helvetica', 'normal'); // Set font style to normal
    pdf.setFontSize(12);

    const item = data[0];
    const date = new Date(item.month);
    const month = date.toLocaleString('default', { month: 'short' });
    const year = date.getFullYear();
    const formattedMonth = `${month}-${year}`;
    pdf.text(`As of: ${formattedMonth}`, 15,y + 15);
    // y += 10;

    const headers = [['Name','Leave Type', 'Balance']];
    const rows = data.map(item => [
        `${item.last_name} ${item.first_name}`,
      item.leave_name,
      item.leave_balance,
    ]);

    pdf.autoTable({
      startY: y + 20,
      head: headers,
      body: rows
    });

    pdf.save('EmployeeLeaveReport.pdf');
}

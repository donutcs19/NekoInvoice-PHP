// JavaScript
const org = 'Neko team'
const buttonContainer = document.getElementById('buttonContainer');

// ฟังก์ชันสำหรับตรวจสอบสถานะจาก API
async function checkStatusAndAppendButton() {
  try {
    const response = await fetch(`https://invoice.nekoth.com/API.php/listBtnStatus/${org}`); // เปลี่ยน URL เป็น API ของคุณ
    const data = await response.json();

    // ตรวจสอบสถานะที่ได้รับจาก API
    if (data.status === '1') {
      // สร้างปุ่มใหม่
      const button = document.createElement('button');
      button.id = 'fetchButton';
      button.textContent = 'Fetch Data';
      button.addEventListener('click', () => {
        console.log('Fetching data...');
        // เพิ่มโค้ดสำหรับ fetch ข้อมูล
      });

      // เพิ่มปุ่มเข้าไปใน container
      buttonContainer.append(button);
    }
  } catch (error) {
    console.error('Error fetching status:', error);
  }
}

// เรียกใช้งานฟังก์ชันเมื่อโหลดหน้าเว็บ
checkStatusAndAppendButton();

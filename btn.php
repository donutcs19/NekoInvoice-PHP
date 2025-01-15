<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>btn-hidden</title>
</head>
<body>
    
	<h1>btn-hidden</h1>
	<!-- HTML -->
<div id="buttonContainer"></div>

</body>
<script>
const buttonContainer = document.getElementById('buttonContainer');

async function checkStatusAndAppendButtons() {
  try {
    const response = await fetch(`https://invoice.nekoth.com/API.php/listBtnStatus/${org}`);
    const data = await response.json();

    console.log(data);

    if (Array.isArray(data)) {
      data.forEach((item, i) => {
        const button = document.createElement('button');
        button.id = `fetchButton-${i}`;
        button.textContent = `Fetch Data ${i + 1}`;

        if (item.status === '4') {
          button.addEventListener('click', () => {
            console.log(`Fetching data for item ${i + 1}`);
          });
        } else {
          button.disabled = true; // ตั้งค่าให้ปุ่มเป็น disabled
          button.textContent += ' (Disabled)';
        }

        // เพิ่มปุ่มเข้าไปใน container
        buttonContainer.append(button);
      });
    } else {
      console.error('Data is not an array:', data);
    }
  } catch (error) {
    console.error('Error fetching status:', error);
  }
}

// เรียกใช้งานฟังก์ชันเมื่อโหลดหน้าเว็บ
checkStatusAndAppendButtons();

</script>
</html>
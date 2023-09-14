import { data } from "autoprefixer";

console.log('admin front-end')
document
   .getElementById('employee_vcard_download')
   .addEventListener('click', function () {

    const fullName = document.getElementById('employee_name').innerText;

    //split full name into first and last name
    const nameArray = fullName.split(' ');
    const firstName = nameArray[0];
    const lastName = nameArray[1];

    const email = document.getElementById('employee_email').innerText;
    const phone = document.getElementById('employee_phone').innerText;
    const designation = document.getElementById('employee_designation').innerText;
    const profileImage = document.getElementById('employee_profile_image').src;

const toDataURL = url => {
    //replace http with https from url
    url = url.replace('http://', 'https://')
    return fetch(url)
  .then(response => response.blob())
  .then(blob => new Promise((resolve, reject) => {
    const reader = new FileReader()
    reader.onloadend = () => resolve(reader.result)
    reader.onerror = reject
    reader.readAsDataURL(blob)
  }))
}


toDataURL(profileImage)
  .then(dataUrl => {

    dataUrl = dataUrl.replace('data:image/jpeg;base64,', '')

const vCardData = `BEGIN:VCARD
VERSION:3.0
N:${lastName};${firstName}
FN:${fullName}
ORG:AuthLab
TITLE: ${designation}
TEL;TYPE=CELL,VOICE:${phone}
EMAIL:${email}
URL:https://authlab.io/
PHOTO;ENCODING=b;TYPE=WEBP:${dataUrl}
END:VCARD`
    
        const blob = new Blob([vCardData], { type: 'text/vcard' })
        const url = window.URL.createObjectURL(blob)
        const a = document.createElement('a')
        a.style.display = 'none'
        a.href = url
        a.download = `${firstName}_${lastName}_vcard.vcf`
        document.body.appendChild(a)
        a.click()
        window.URL.revokeObjectURL(url)
  })
})

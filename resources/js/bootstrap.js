/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
 
import Pusher from 'pusher-js';
window.Pusher = Pusher;
 
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Inisialisasi DataTable
let rfidtable = $('#rfidTable').DataTable({
    "paging": true,
    "processing": true,
    "lengthChange": true,
    "searching": true,
    "info": true,
    "autoWidth": false,
    "responsive": false,
    "ordering": true,
    "serverSide": false,
    "destroy": true,
    "oLanguage": {
        "sEmptyTable": "Waiting scanner data"
    },
    columns: [
        { data: 'rfid_number' },
        { data: 'timestamp' }
    ]
});

let documentTable = $('#documentTable').DataTable({
    "paging": true,
    "processing": true,
    "lengthChange": true,
    "searching": true,
    "info": true,
    "autoWidth": false,
    "responsive": false,
    "ordering": false,
    "scrollX": true,
    "serverSide": false,
    "destroy": true,
});

// Variabel untuk menyimpan jumlah total
let totalRFID = 0;
let totalIsThereTrue = 0;
let totalIsThereFalse = 0;

window.Echo.channel("tag-scanned").listen("TagScanned",(event)=>{
   totalRFID = event.scannedTags.length;

    updateDocumentTable(() => {
        updateRFIDTable(event);
    });
});

// ========== FUNGSI UPDATE TABLE Document ==========
function updateDocumentTable(callback = null) {
    $.getJSON('/api/documents', function(data) {
        documentTable.clear();

        totalIsThereTrue = 0;
        totalIsThereFalse = 0;

        data.forEach((document) => {
            let rowNode = documentTable.row.add([
                document.is_there ? ' <strong>FOUND</strong>' : '<strong>MISSING</strong>',
                document.rfid_number,
                document.code,
                document.name,
                document.condition,
                document.user.username,
                document.gedung,
                document.lantai,
                document.ruangan
            ]).node();

            if (document.is_there) {
                totalIsThereTrue++;
                $(rowNode).addClass('bg-success-2');
            } else {
                totalIsThereFalse++;
                $(rowNode).addClass('bg-danger-2');
            }
        });
        documentTable.draw();
        updateTotalDisplay();
        if (callback) callback();
    });
}

function updateRFIDTable(event) {
   rfidtable.clear();
    event.scannedTags.forEach((rfid) => {
        rfidtable.row.add({
            rfid_number: rfid, 
            timestamp: new Date().toLocaleTimeString('id-ID', { 
                hour: '2-digit', minute: '2-digit', second: '2-digit' 
            })
        });
    });
    rfidtable.draw();
}

// Fungsi untuk update tampilan total
function updateTotalDisplay() {
    $('#totalRFID').text(totalRFID);
    $('#totalIsThereTrue').text(totalIsThereTrue);
    $('#totalIsThereFalse').text(totalIsThereFalse);
}

// Panggil pertama kali saat halaman dimuat
updateDocumentTable();


// /**
//  * Echo exposes an expressive API for subscribing to channels and listening
//  * for events that are broadcast by Laravel. Echo and event broadcasting
//  * allow your team to quickly build robust real-time web applications.
//  */

// import './echo';

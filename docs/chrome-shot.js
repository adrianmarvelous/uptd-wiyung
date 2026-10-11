/**
 * docs/chrome-shot.js
 * Ambil screenshot MOBILE VIEW memakai Google Chrome ASLI (headless + CDP).
 * Jalankan:  node docs\chrome-shot.js
 */
const fs = require('fs');
const path = require('path');

const PORT = 9333;
const BASE = 'https://lightcyan-cassowary-764104.hostingersite.com';
const OUT = path.join(__dirname, 'img');
const W = 572;
const H = 800;
const UA = 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36';
const USER = 'uptb_wiyung';
const PASS = 'uptb_wiyung';
const NARASI = 'Telah dilakukan pemeriksaan terhadap Wajib Pajak terkait kewajiban perpajakan daerah. Demikian berita acara ini dibuat untuk dipergunakan sebagaimana mestinya.';

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

(async () => {
    const list = await (await fetch(`http://127.0.0.1:${PORT}/json/list`)).json();
    const target = list.find((t) => t.type === 'page');
    if (!target) throw new Error('Tidak ada page target di Chrome');

    const ws = new WebSocket(target.webSocketDebuggerUrl);
    let seq = 0;
    const pending = new Map();

    ws.addEventListener('message', (ev) => {
        const m = JSON.parse(ev.data);
        if (m.id && pending.has(m.id)) {
            const p = pending.get(m.id);
            pending.delete(m.id);
            m.error ? p.reject(new Error(JSON.stringify(m.error))) : p.resolve(m.result);
        }
    });
    await new Promise((r) => ws.addEventListener('open', r));

    const send = (method, params = {}) =>
        new Promise((resolve, reject) => {
            const i = ++seq;
            pending.set(i, { resolve, reject });
            ws.send(JSON.stringify({ id: i, method, params }));
        });

    await send('Page.enable');
    await send('Runtime.enable');

    // === MOBILE VIEW (sama seperti tombol "Toggle device toolbar" di Chrome DevTools) ===
    await send('Emulation.setDeviceMetricsOverride', {
        width: W, height: H, deviceScaleFactor: 1, mobile: true, screenWidth: W, screenHeight: H,
    });
    await send('Emulation.setTouchEmulationEnabled', { enabled: true, maxTouchPoints: 5 });
    await send('Emulation.setUserAgentOverride', { userAgent: UA });

    const js = async (expression, awaitPromise = false) => {
        const r = await send('Runtime.evaluate', { expression, returnByValue: true, awaitPromise });
        if (r.exceptionDetails) {
            const d = r.exceptionDetails.exception ? r.exceptionDetails.exception.description : JSON.stringify(r.exceptionDetails);
            throw new Error('JS error: ' + d);
        }
        return r.result ? r.result.value : null;
    };

    const go = async (url, wait = 2500) => { await send('Page.navigate', { url }); await sleep(wait); };

    const shot = async (name) => {
        await js('window.scrollTo(0,0)');
        await sleep(350);
        const r = await send('Page.captureScreenshot', { format: 'png', captureBeyondViewport: false });
        const file = path.join(OUT, name);
        fs.writeFileSync(file, Buffer.from(r.data, 'base64'));
        const b = fs.readFileSync(file);
        console.log('  saved', name, b.readUInt32BE(16) + 'x' + b.readUInt32BE(20));
    };

    const setValue = `const set=(s,v)=>{const e=document.querySelector(s); if(!e) return; e.value=v; e.dispatchEvent(new Event('input',{bubbles:true}));};`;

    // ---------- LOGIN ----------
    console.log('login...');
    await go(BASE + '/login', 2800);
    await js(`(() => { ${setValue} set('input[name="username"]', ${JSON.stringify(USER)}); set('input[name="password"]', ${JSON.stringify(PASS)}); document.querySelector('form[action$="/login"]').requestSubmit(); return 'ok'; })()`);
    await sleep(3400);
    const afterLogin = await js('location.href');
    console.log('  url:', afterLogin);
    if (String(afterLogin).includes('/login')) throw new Error('LOGIN GAGAL (masih di /login)');

    console.log('mengambil screenshot...');
    // 02 dashboard
    await go(BASE + '/', 2600);
    await shot('02-dashboard.png');

    // 03 daftar (filter bulan default)
    await go(BASE + '/berita_acara/OP', 2600);
    await shot('03-daftar-berita-acara.png');

    // 04 modal
    await js(`(() => { const b = document.querySelector('button[data-bs-target="#exampleModal"]'); if (b) b.click(); return !!b; })()`);
    await sleep(1500);
    await shot('04-modal-buat.png');

    // 05 formulir (kirim ke /berita_acara/create -> hanya render, tidak menyimpan)
    await js(`(() => { ${setValue} set('#exampleModal input#nop', '35.78.090.006.903.00456'); set('#exampleModal input#nama', 'HAPPY HAPPY CLUB'); set('#exampleModal input#alamat', 'JL. ARJUNO 77'); document.querySelector('#exampleModal form').submit(); return 'ok'; })()`);
    await sleep(2800);
    await shot('05-form-buat.png');

    // 06 tanda tangan (kirim ke /approval_wajib_pajak -> hanya render, TIDAK menyimpan)
    await js(`(() => { ${setValue} set('input[name="nama_responden"]', 'Budi Santoso'); set('input[name="telp"]', '6281234567890'); const ta=document.querySelector('textarea[name="narasi"]'); if(ta) ta.value=${JSON.stringify(NARASI)}; const ed=document.querySelector('.note-editable'); if(ed) ed.innerHTML='<p>'+${JSON.stringify(NARASI)}+'</p>'; const sels=document.querySelectorAll('select[name="pegawai1"]'); if(sels.length) sels[sels.length-1].selectedIndex=1; document.querySelector('form[action*="approval_wajib_pajak"]').requestSubmit(); return 'ok'; })()`);
    await sleep(3000);
    await shot('06-tanda-tangan.png');

    // 07 profil
    await go(BASE + '/profile', 2800);
    await shot('07-profil.png');

    // 01 login (logout dulu)
    await js(`(async () => { const t=document.querySelector('input[name="_token"]').value; const fd=new FormData(); fd.append('_token', t); await fetch('/logout',{method:'POST',body:fd,credentials:'same-origin'}); return 'ok'; })()`, true);
    await sleep(1400);
    await go(BASE + '/login', 2600);
    await shot('01-login.png');

    console.log('SELESAI');
    ws.close();
    process.exit(0);
})().catch((e) => {
    console.error('ERROR:', e.message);
    process.exit(1);
});

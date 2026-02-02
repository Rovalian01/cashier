let cartCache = {};

function renderInvoice(cart) {
    let table = document.querySelector(".invoices-details table");
    let html = `
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
    `;

    let total = 0;

    for (let id in cart) {
        let item = cart[id];
        let sub = item.qty * item.harga;
        total += sub;

        html += `
            <tr>
                <td>${item.nama}</td>
                <td>${item.qty}</td>
                <td>${item.harga}</td>
                <td>${sub}</td>
            </tr>
        `;
    }

    table.innerHTML = html;
    document.getElementById("total-amount").innerText = total;
    
    // Update payment form total
    if (document.getElementById('payment-total')) {
        document.getElementById('payment-total').textContent = total;
    }
}

// Listen to pembayaran input for kembalian calculation
if (document.getElementById('jumlah-pembayaran')) {
    document.getElementById('jumlah-pembayaran').addEventListener('input', (e) => {
        const jumlah = parseInt(e.target.value) || 0;
        const total = parseInt(document.getElementById('payment-total').textContent) || 0;
        const kembalian = jumlah - total;
        
        if (kembalian >= 0 && jumlah > 0) {
            document.getElementById('kembalian-display').style.display = 'block';
            document.getElementById('kembalian-amount').textContent = 'Rp. ' + kembalian.toLocaleString('id-ID');
        } else {
            document.getElementById('kembalian-display').style.display = 'none';
        }
    });
}

async function addToInvoice(btn) {
    try {
        const res = await fetch("api/add_to_invoice.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: `id=${btn.dataset.id}&nama=${btn.dataset.nama}&harga=${btn.dataset.harga}`
        });

        const cart = await res.json();
        cartCache = cart;
        renderInvoice(cart);
        // persist a client copy (optional)
        localStorage.setItem('cart', JSON.stringify(cart));

    } catch (err) {
        console.error("Gagal add:", err);
        alert("Gagal menambahkan produk!");
    }
}

async function removeFromInvoice(btn) {
    try {
        const res = await fetch("api/remove_from_invoice.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: `id=${btn.dataset.id}`
        });

        const cart = await res.json();
        cartCache = cart;
        renderInvoice(cart);
        localStorage.setItem('cart', JSON.stringify(cart));

    } catch (err) {
        console.error("Gagal hapus:", err);
        alert("Gagal menghapus produk!");
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    // wire up product buttons
    document.querySelectorAll(".add-to-invoice").forEach(btn => {
        btn.addEventListener("click", () => addToInvoice(btn));
    });

    // fix selector typo and wire delete buttons
    document.querySelectorAll(".delete-from-invoice").forEach(btn => {
        btn.addEventListener("click", () => removeFromInvoice(btn));
    });

    // load cart from server (session) so it persists across reloads
    try {
        const res = await fetch('api/get_cart.php');
        const serverCart = await res.json();
        if (serverCart && Object.keys(serverCart).length > 0) {
            cartCache = serverCart;
            renderInvoice(serverCart);
            localStorage.setItem('cart', JSON.stringify(serverCart));
            return;
        }

        // fallback: restore from localStorage if session empty
        const stored = localStorage.getItem('cart');
        if (stored) {
            const parsed = JSON.parse(stored);
            cartCache = parsed;
            renderInvoice(parsed);
        }
    } catch (err) {
        console.error('Gagal memuat cart:', err);
    }
});
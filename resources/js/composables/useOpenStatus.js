import { computed, ref } from 'vue';

const TIMEZONE = 'Asia/Jakarta'; 

const toMinutes = (time) => {
    if (!time) return 0;
    const [h, m] = String(time).split(':').map(Number);
    return h * 60 + m;
};

const getNowMinutes = () => {
    const text = new Date().toLocaleTimeString('en-GB', {
        timeZone: TIMEZONE,
        hour: '2-digit',
        minute: '2-digit',
        hourCycle: 'h23',
    });
    return toMinutes(text);
};

const nowMinutes = ref(getNowMinutes());
let ticker = null;

const startTicker = () => {
    if (ticker) return;
    ticker = setInterval(() => (nowMinutes.value = getNowMinutes()), 30000);
};

export function isOpenAt(opening, closing, now) {
    const open = toMinutes(opening);
    const close = toMinutes(closing);

    if (open === close) return true;                
    if (open < close) return now >= open && now < close;
    return now >= open || now < close;              
}

export function useOpenStatus(restaurantsRef) {
    startTicker();

    // Ini kuncinya biar ga ribet! 
    // Kita olah datanya di sini, biar di template HTML tinggal pakai.
    const restaurantsWithStatus = computed(() => {
        if (!restaurantsRef.value || !Array.isArray(restaurantsRef.value)) return [];

        return restaurantsRef.value.map((resto) => {
            // PERHATIKAN: Pastikan namanya sesuai dengan di database (open_time & close_time)
            const isOpen = isOpenAt(resto.open_time, resto.close_time, nowMinutes.value);

            return {
                ...resto, // Bawa semua data asli dari database
                isOpen: isOpen,
                label: isOpen
                    ? `Buka · tutup pukul ${String(resto.close_time).slice(0, 5)}`
                    : `Tutup · buka pukul ${String(resto.open_time).slice(0, 5)}`
            };
        });
    });

    return { restaurantsWithStatus };
}
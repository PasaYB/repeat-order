import { ref } from 'vue';

export function useUserLocation() {
    const position = ref(null); // [lat, lng]
    const place = ref(null);    // { kelurahan, kecamatan, kota, provinsi }
    const loading = ref(false);
    const error = ref('');

    const getPosition = () =>
        new Promise((resolve, reject) => {
            if (!('geolocation' in navigator)) {
                return reject(new Error('Browser tidak mendukung geolokasi.'));
            }
            navigator.geolocation.getCurrentPosition(resolve, reject, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 60000,
            });
        });

    const reverseGeocode = async (lat, lng) => {
        const params = new URLSearchParams({
            format: 'jsonv2',
            lat,
            lon: lng,
            zoom: '16',
            addressdetails: '1',
            'accept-language': 'id',
        });

        const res = await fetch(`https://nominatim.openstreetmap.org/reverse?${params}`);
        if (!res.ok) throw new Error('Gagal mengambil nama lokasi.');

        const { address = {} } = await res.json();
        console.log('alamat mentah:', address);

        return {
            kelurahan: address.village || address.suburb || address.neighbourhood || null,
            kecamatan: address.city_district || address.district || address.county || address.municipality || null,
            kota: address.city || address.town || address.regency || address.state_district || null,
            provinsi: address.state || null,
        };
    };

    const CACHE_KEY = 'user_location';

    const locate = async ({ force = false } = {}) => {
        if (!force) {
            try {
                const cached = JSON.parse(sessionStorage.getItem(CACHE_KEY));
                if (cached?.position && cached?.place) {
                    position.value = cached.position;
                    place.value = cached.place;
                    return;
                }
            } catch {}
        }

        loading.value = true;
        error.value = '';

        try {
            const { coords } = await getPosition();
            position.value = [coords.latitude, coords.longitude];
            place.value = await reverseGeocode(coords.latitude, coords.longitude);

            try {
                sessionStorage.setItem(
                    CACHE_KEY,
                    JSON.stringify({ position: position.value, place: place.value }),
                );
            } catch {}
        } catch (e) {
            error.value =
                e.code === 1 ? 'denied'
                : e.code === 2 ? 'Lokasi tidak tersedia.'
                : e.code === 3 ? 'Waktu pencarian lokasi habis.'
                : e.message || 'Terjadi kesalahan.';
        } finally {
            loading.value = false;
        }
    };

    return {
        position,
        place,
        loading,
        error,
        locate,
    };
}
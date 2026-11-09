const EARTH_RADIUS_KM = 6371;
const RATE_PER_KM = 2500;
const MIN_FEE = 5000; 
const FALLBACK_FEE = 10000; 

const toRad = (deg) => (deg * Math.PI) / 180;

export function distanceKm(a, b) {
    const [lat1, lng1] = a.map(Number);
    const [lat2, lng2] = b.map(Number);

    const dLat = toRad(lat2 - lat1);
    const dLng = toRad(lng2 - lng1);

    const h =
        Math.sin(dLat / 2) ** 2 +
        Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * Math.sin(dLng / 2) ** 2;

    return 2 * EARTH_RADIUS_KM * Math.asin(Math.sqrt(h));
}

export function calculateDeliveryFee(userPosition, restaurant) {
    if (!userPosition || restaurant?.latitude == null || restaurant?.longitude == null) {
        return { distance: null, fee: FALLBACK_FEE };
    }

    const distance = distanceKm(userPosition, [restaurant.latitude, restaurant.longitude]);

    const fee = Math.max(MIN_FEE, Math.ceil(distance) * RATE_PER_KM);

    return { distance, fee };
}
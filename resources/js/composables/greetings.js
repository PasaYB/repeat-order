export const greetings = [
    'What are you craving today?',
    'Ready for something delicious?',
    'What sounds good right now?',
    "Hungry? Let's fix that.",
    'What should we eat today?',
    'Time for a tasty break!',
    'Your next favorite meal is waiting.',
    'Got a craving? We got you.',
    "Let's find you something yummy.",
    "What's on the menu for you today?",
    'Feeling snacky or starving?',
    'Good food is just a few taps away.',
    'Treat yourself today!',
    'Fried, grilled, or sweet? You choose.',
    'Your stomach called, it wants dinner.',
    "Let's turn that hunger into happiness.",
    'Something warm, something sweet, or both?',
    "Can't decide? Try our gacha!",
    "Let's eat something great today.",
    'Skip the cooking, enjoy the eating.',
];

const KEY = 'greeting';

export function getGreeting() {
    try {
        const saved = sessionStorage.getItem(KEY);
        if (saved) return saved;

        const text = greetings[Math.floor(Math.random() * greetings.length)];
        const picked = text.charAt(0).toLowerCase() + text.slice(1);
        sessionStorage.setItem(KEY, picked);
        return picked;
    } catch {
        return greetings[Math.floor(Math.random() * greetings.length)];
    }
}

export const resetGreeting = () => {
    try {
        sessionStorage.removeItem(KEY);
    } catch {}
};
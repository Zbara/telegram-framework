import { DateTime } from "luxon";
export default {
    methods: {
        getDate(date) {
            const userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

            if (date !== null && date !== undefined) {
                // Пытаемся распарсить в формате 'yyyy-MM-dd HH:mm:ss'
                let parsedDate = DateTime.fromFormat(date, 'yyyy-MM-dd HH:mm:ss', { zone: 'UTC' });
                if (!parsedDate.isValid) {
                    // Если парсинг не удался, пробуем распарсить в формате ISO 8601
                    parsedDate = DateTime.fromISO(date, { zone: 'UTC' });
                }
                // Если дата валидна, конвертируем в пользовательский часовой пояс и возвращаем строку
                if (parsedDate.isValid) {
                    return parsedDate.setZone(userTimeZone).toLocaleString(DateTime.DATETIME_MED);
                } else {
                    // Если дата не удалось распарсить, возвращаем 'No Date'
                    return 'No Date';
                }
            }
            return 'No Date';
        },
        // Другие глобальные методы, если есть
        generateHash() {
            const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            let result = "";
            const length = 10; // длина случайной строки

            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                result += characters.charAt(randomIndex);
            }
            return result;
        },
        getNounForm(number, forms) {
            const cases = [2, 0, 1, 1, 1, 2];
            return forms[(number % 100 > 4 && number % 100 < 20) ? 2 : cases[Math.min(number % 10, 5)]];
        }
    }
};

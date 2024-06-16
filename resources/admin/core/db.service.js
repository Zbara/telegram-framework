// Открываем или создаем базу данных
const dbName = 'authTokensDB';
const request = indexedDB.open(dbName, 1);

// Обработка событий при открытии или создании базы данных
request.onupgradeneeded = function(event) {
    const db = event.target.result;

    // Создаем хранилище объектов (Object Store)
    const objectStore = db.createObjectStore('authTokens', { keyPath: 'id' });

    // Добавляем индекс для поиска по токену (необязательно)
    objectStore.createIndex('tokenIndex', 'token', { unique: false });
};

// Обработка событий при успешном открытии базы данных
request.onsuccess = function(event) {
    const db = event.target.result;

    // Функция для сохранения токена в базе данных
    function saveToken(token) {
        const transaction = db.transaction(['authTokens'], 'readwrite');
        const objectStore = transaction.objectStore('authTokens');

        // Добавляем запись с токеном
        objectStore.add({ id: 1, token: token });
    }

    // Функция для получения токена из базы данных
    function getToken(callback) {
        const transaction = db.transaction(['authTokens'], 'readonly');
        const objectStore = transaction.objectStore('authTokens');

        // Получаем запись по ключу
        const request = objectStore.get(1);

        request.onsuccess = function(event) {
            const token = event.target.result ? event.target.result.token : null;
            callback(token);
        };
    }

    // Пример использования функций
    saveToken('yourAuthToken123');

    getToken(function(token) {
        console.log('Stored Token:', token);
    });
};

// Обработка событий при ошибке открытия базы данных
request.onerror = function(event) {
    console.error('Error opening database:', event.target.error);
};


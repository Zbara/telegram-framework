export default function authHeader() {
    let user = JSON.parse(localStorage.getItem('token'));

    if (user && user.access_token) {
        return {
            Authorization: 'Bearer ' + user.access_token,
            'Content-Type': 'application/json',
        };
    } else {
        return {};
    }
}

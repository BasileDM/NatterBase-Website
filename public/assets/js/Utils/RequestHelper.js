export class RequestHelper {
    static async post(url, data) {
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });
            if (!response.ok) {
                throw new Error(`Error: ${response.status}`);
            }
            return await response.json();
        }
        catch (error) {
            console.error('Request failed', error);
        }
    }
    static async get(url) {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Error: ${response.status}`);
            }
            return await response.json();
        }
        catch (error) {
            console.error('Request failed', error);
        }
    }
}

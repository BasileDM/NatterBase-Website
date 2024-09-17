export class RequestHelper {
  static async post(url: string, data: object): Promise<Response> {
    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      });
      return response;
    }
    catch (error) {
      console.error('Unexpected error: ', error);
      throw new Error('Failed sending request. Try again later.');
    }
  }

  static async get(url: string): Promise<Response|void> {
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

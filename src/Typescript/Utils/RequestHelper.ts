import { Toast } from '../Components/Toast.js';

export class RequestHelper {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  static async post(url: string, data: object): Promise<any|null> {
    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      });

      const result = await response.json();

      if (!response.ok) {
        new Toast('error', result.message || 'An error occurred');
        return null;
      }

      return result;
    }
    catch (error) {
      console.error('Unexpected error: ', error);
      new Toast('error', 'Failed sending request. Try again later.');
      return null;
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

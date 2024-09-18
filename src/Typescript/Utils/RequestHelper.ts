import { Toast } from '../Components/Toast.js';

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

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  static async handleResponse(response: Response): Promise<any|false> {
    const responseBody = await response.json();
    if (!response.ok && responseBody.message) {
      new Toast('error', 'Error: ' + responseBody.message);
      return false;
    }

    return responseBody;
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

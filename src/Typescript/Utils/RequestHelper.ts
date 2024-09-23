/* eslint-disable @typescript-eslint/no-explicit-any */
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

  static async get(url: string, param: number|null = null): Promise<Response> {
    try {
      if (param !== null) {
        const requestBody = `?param=${param}`;
        url = url + requestBody;
      }
      const response = await fetch(url);

      if (!response.ok) {
        throw new Error(`Error: ${response.status}`);
      }

      return response;
    }
    catch (error) {
      console.error('Request failed', error);
      throw new Error('Request failed. Try again later.');
    }
  }

  static async handleResponse(response: Response): Promise<any|false> {
    const responseBody = await response.json();
    if (!response.ok && responseBody.message) {
      new Toast('error', 'Error: ' + responseBody.message);
      return false;
    }

    return responseBody;
  }

  public static async getUserData(): Promise<any|false> {
    const response = await RequestHelper.get('/api/userData');
    const jsonResponseBody = await RequestHelper.handleResponse(response);
    return jsonResponseBody;
  }
}

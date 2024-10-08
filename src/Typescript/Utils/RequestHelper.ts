/* eslint-disable @typescript-eslint/no-explicit-any */
import { Toast } from '../Components/Toast.js';

export class RequestHelper {

  /**
   *
   * Main requests methods (POST, GET, DELETE)
   *
   */

  // POST
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

  // GET
  static async get(url: string): Promise<Response> {
    try {
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

  // DELETE
  static async delete(url: string): Promise<Response> {
    try {
      const response = await fetch(url, {
        method: 'DELETE',
      });
      return response;
    }
    catch (error) {
      console.error('Unexpected error: ', error);
      throw new Error('Failed sending request. Try again later.');
    }
  }

  /**
   *
   * Helper methods
   *
   */
  static async handleResponse(response: Response): Promise<any|false> {
    const responseBody = await response.json();
    if (!response.ok && responseBody.message) {
      new Toast('error', 'Error: ' + responseBody.message);
      return false;
    }

    return responseBody;
  }

  public static async getUserData(): Promise<any|false> {
    const response = await RequestHelper.get('./api/userData');
    const jsonResponseBody = await RequestHelper.handleResponse(response);
    return jsonResponseBody;
  }
}

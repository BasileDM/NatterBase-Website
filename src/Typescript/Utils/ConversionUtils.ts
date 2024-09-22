export class ConversionUtils {
  public static UTCtoLocalDate(utcDate: string): string {
    // Appending 'Z' indicates UTC time
    const date = new Date(utcDate + 'Z');
    return date.toLocaleString();
  }
}
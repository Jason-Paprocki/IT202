import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.*;

public class test
{

  public static void main(String[] args)
  {
    try
    {
       String data = "token=2042647aa12c05cd6b2234ef0e790719";
       URL url = new URL("https://web.njit.edu/~jdp84/IT202/project/tokenLogin.php");
       HttpURLConnection con = (HttpURLConnection) url.openConnection();
       con.setRequestMethod("POST");
       con.setDoOutput(true);
       con.getOutputStream().write(data.getBytes("UTF-8"));
       con.getInputStream();


       int responseCode = con.getResponseCode();
       System.out.println("nSending 'POST' request to URL : " + url);
       System.out.println("Response Code : " + responseCode);


       BufferedReader in = new BufferedReader(
        new InputStreamReader(con.getInputStream()));
        String output;
        StringBuffer response = new StringBuffer();

        while ((output = in.readLine()) != null) {
        response.append(output);
        }
        in.close();

        //printing result from response
        System.out.println(response.toString());
    }
    catch (Exception e)
    {
        System.out.println(e);
    }
  }

}
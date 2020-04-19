import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.*;

public class checkTime {
    private static String token;

    public checkTime() {
    }
    public checkTime(String token) {
        this.token = token;
    }

    public void main(String[] args) throws UnsupportedEncodingException, IOException 
    {
        sendPost(token);
    }

    public boolean sendPost(String token) throws UnsupportedEncodingException, IOException
    {

    //authencation defaults to false and changes based on response codes
    boolean part1 = false;
    boolean part2 = false;
    boolean authenticate = false;

    //data from the user
    String data = "token=" + token;
    URL url = new URL("https://web.njit.edu/~jdp84/IT202/project/tokenLogin.php");
    HttpURLConnection con = (HttpURLConnection) url.openConnection();
    con.setRequestMethod("POST");
    con.setDoOutput(true);
    con.getOutputStream().write(data.getBytes("UTF-8"));
    con.getInputStream();


    int responseCode = con.getResponseCode();
    if (responseCode == 200)
    {
        part1 = true;
    }


    BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
    String output;
    StringBuffer response = new StringBuffer();

    while ((output = in.readLine()) != null) 
    {
        response.append(output);
    }
    in.close();

    if (Integer.parseInt(response.toString()) == 1)
    {
        part2 = true;
    }
    
    if (part1 && part2)
    {
        authenticate = true;
        return authenticate;
    }
    else
    {
        return authenticate;
    }
    
  }

  public String getToken()
  {
      return token;
  }
}
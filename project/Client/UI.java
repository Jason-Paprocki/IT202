import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.HashMap;
import java.util.Map;
import java.awt.*;
import java.io.*;
import java.net.*;
import javax.imageio.*;
import javax.swing.JOptionPane;
import java.util.concurrent.TimeUnit;

public class UI {

	public static void main(String[] args) {
		boolean run = false;

		if (tokenMessage()) {
			run = true;
		}

		if (run) {

			// crete the Java frame and panel
			JFrame frame = new JFrame("A Simple Proxy");
			frame.setVisible(true);
			frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

			// create the new panel
			JPanel panel = new JPanel();
			frame.add(panel);

			// create box to vertically align things
			Box box = Box.createVerticalBox();
			panel.add(box);

			// label to specify server
			JLabel lbl = new JLabel("Select one server: ");
			lbl.setAlignmentX(Component.CENTER_ALIGNMENT);
			box.add(lbl);

			// add servers here
			HashMap<String, String> addresses = new HashMap<>();
			addresses.put("Server 1", "192.168.0.224");
			addresses.put("Server 2", "128.235.211.21");

			// show choices with a combo box
			String[] choices = { "Server 1", "Server 2", "Server 3", "Server 4", "Server 5", "Server 6" };
			JComboBox<String> cb = new JComboBox<String>(choices);
			cb.setAlignmentX(Component.CENTER_ALIGNMENT);
			box.add(cb);

			// show button for conencting
			JButton btn = new JButton();
			btn.setText("CONNECT");
			btn.setAlignmentX(Component.CENTER_ALIGNMENT);
			box.add(btn);

			// text to show user if they are connected
			JLabel isRunning = new JLabel("DISCONNECTED from Proxy");
			isRunning.setAlignmentX(Component.CENTER_ALIGNMENT);
			box.add(isRunning);

			// show button for disconnecting
			JButton discbtn = new JButton();
			discbtn.setText("DISCONNECT");
			discbtn.setAlignmentX(Component.CENTER_ALIGNMENT);
			box.add(discbtn);

			// onclick action for the connect button
			btn.addActionListener(new ActionListener() {
				@Override
				public void actionPerformed(ActionEvent e) {
					Thread connectionThread = new Thread() {
						@Override
						public void run() {
							isRunning.setText("CONNECTED to Proxy");
							String whichServer = cb.getSelectedItem().toString();
							String ipAddress = addresses.get(whichServer);
							Client myServer = new Client(ipAddress, 8080);
							myServer.listen();
						}
					};
					connectionThread.start();
				}
			});

			// onclick action for the disconnect button
			discbtn.addActionListener(new ActionListener() {
				@Override
				public void actionPerformed(ActionEvent e) {
					Thread disconnectionThread = new Thread() {
						@Override
						public void run() {
							System.exit(0);
						}
					};
					disconnectionThread.start();
				}
			});

			// new thread to check connections to improve startup time
			Thread serverOnline = new Thread() {
				public void run() {
					// check status
					String server;
					for (int i = 0; i < addresses.size(); i++) {
						server = addresses.get("Server " + (i + 1)).toString();
						JLabel onlineServer = new JLabel(server + " is " + hostAvailabilityCheck(server));
						onlineServer.setAlignmentX(Component.CENTER_ALIGNMENT);
						box.add(onlineServer);
						frame.pack();
						frame.setSize(500, 800);
					}
				}

			};
			serverOnline.start();

			// new thread to check connections to improve startup time
			Thread authenticationCheck = new Thread() 
			{
				public void run() 
				{
					while(true)
					{
						try 
						{
							
							TimeUnit.MINUTES.sleep(60);
							
							checkTime checker = new checkTime();
							String token = checker.getToken();
							boolean validTime = checker.sendPost(token);
							if (!validTime)
							{
								throw new IOException();
							}	
						} 
						catch (InterruptedException | IOException e) 
						{
							// TODO Auto-generated catch block
							JFrame parent = new JFrame();
							JOptionPane.showMessageDialog(parent,
							"Your token has no time left",
							"Error",
							JOptionPane.ERROR_MESSAGE);
							System.exit(0);
						}
					}
					
				}
			};
			
			authenticationCheck.start();

			// packs the frame neatly and resizes it
			frame.pack();
			frame.setSize(500, 800);
		}
	}

	// this will check the availablility of the server by atempting to create socket
	// connection
	public static String hostAvailabilityCheck(String inServer) {
		try {
			Socket socket = new Socket();
			socket.connect(new InetSocketAddress(inServer, 8080), 2000);
			socket.close();
			return "UP";
		} catch (IOException ex) {
			return "DOWN";
		}

	}

	public static boolean tokenMessage() {
		JFrame parent = new JFrame();
		JButton button = new JButton();
		button.setText(
				"<html>Please Copy your token from your Account page<br /><center>Click to Dismiss</center></html>");
		parent.add(button);
		parent.setVisible(true);
		button.addActionListener(new java.awt.event.ActionListener() 
		{
			@Override
			public void actionPerformed(java.awt.event.ActionEvent evt) {
				String token = JOptionPane.showInputDialog(parent, "Enter Token", null);
				parent.setVisible(false);
				checkTime checker = new checkTime(token);
				boolean validTime = false;
				try 
				{
					validTime = checker.sendPost(token);
					if (!validTime)
					{
						throw new IOException();
					}
				} 
				catch (IOException e) 
				{
					// TODO Auto-generated catch block
					JOptionPane.showMessageDialog(parent,
    				"Your token has no time left",
    				"Error",
					JOptionPane.ERROR_MESSAGE);
					System.exit(0);
				}
            }
		});
		parent.pack();
		parent.setSize(500, 800);
		return true;
	}
}

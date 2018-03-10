/**
 * 
 */
package gash.router.client;

import java.io.IOException;
import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;
import java.net.InterfaceAddress;
import java.net.NetworkInterface;
import java.util.Enumeration;
import java.util.logging.Level;
import java.util.logging.Logger;

import gash.router.app.ConnectApp;
import gash.router.app.DemoApp;

/**
 * @author kartknair
 *
 */
public class AutoClient {
	
	DatagramSocket c;
	int toConnectHostPort = 4567;
	
	

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		
		AutoClient dc = new AutoClient();
				dc.client();
	}

	public void client(){

		// Find the server using UDP broadcast
        try {
          //Open a random port to send the package
          c = new DatagramSocket();
          c.setBroadcast(true);

          byte[] sendData = "DISCOVER_SERVER_REQUEST".getBytes();

          //Try the 255.255.255.255 first
          try {
            DatagramPacket sendPacket = new DatagramPacket(sendData, sendData.length, InetAddress.getByName("255.255.255.255"), 4567);
            c.send(sendPacket);
            System.out.println(getClass().getName() + ">>> Request packet sent to: 255.255.255.255 (DEFAULT)");
          } catch (Exception e) {
          }

          // Broadcast the message over all the network interfaces
          Enumeration interfaces = NetworkInterface.getNetworkInterfaces();
          while (interfaces.hasMoreElements()) {
            NetworkInterface networkInterface = (NetworkInterface) interfaces.nextElement();

            if (networkInterface.isLoopback() || !networkInterface.isUp()) {
              continue; // Don't want to broadcast to the loopback interface
            }

            for (InterfaceAddress interfaceAddress : networkInterface.getInterfaceAddresses()) {
              InetAddress broadcast = interfaceAddress.getBroadcast();
              if (broadcast == null) {
                continue;
              }

              // Send the broadcast package!
              try {
                DatagramPacket sendPacket = new DatagramPacket(sendData, sendData.length, broadcast, toConnectHostPort);
                c.send(sendPacket);
              } catch (Exception e) {
              }

              System.out.println(getClass().getName() + ">>> Request packet sent to: " + broadcast.getHostAddress() + "; Interface: " + networkInterface.getDisplayName());
            }
          }

          System.out.println(getClass().getName() + ">>> Done looping over all network interfaces. Now waiting for a reply!");

          //Wait for a response
          byte[] recvBuf = new byte[15000];
          DatagramPacket receivePacket = new DatagramPacket(recvBuf, recvBuf.length);
          c.receive(receivePacket);

          //We have a response
          System.out.println(getClass().getName() + ">>> Broadcast response from server: " + receivePacket.getAddress().getHostAddress());

          //Check if the message is correct
          String message = new String(receivePacket.getData()).trim();
          String toConnectHostIP = null;
          if (message.equals("DISCOVER_SERVER_RESPONSE")) {
            //DO SOMETHING WITH THE SERVER'S IP (for example, store it in your controller)
            //Controller_Base.setServerIp(receivePacket.getAddress());
        	  System.out.println(receivePacket.getAddress());
        	  toConnectHostIP = receivePacket.getAddress().toString();
      		if (null != toConnectHostIP) {
    			try {
    				MessageClient mc = new MessageClient(toConnectHostIP.substring(1), toConnectHostPort);
    				ConnectApp ca = new ConnectApp(mc);

    				// do stuff w/ the connection
    				ca.ping(5);

    				System.out.println("\n** exiting in 10 seconds. **");
    				System.out.flush();
    				Thread.sleep(10 * 1000);
    			} catch (Exception e) {
    				e.printStackTrace();
    			} finally {
    				CommConnection.getInstance().release();
    			}
    		}
          }
          c.close();
        } catch (IOException ex) {
          //Logger.getLogger(LoginWindow.class.getName()).log(Level.SEVERE, null, ex);
        	System.out.println("exception "+ex);
        }

	
	}
}

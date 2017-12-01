/**
 * 
 */
package app;

import java.net.InetAddress;
import java.net.NetworkInterface;
import java.util.Enumeration;

/**
 * @author kartknair
 *
 */
public class MyConstants {
	
	public static final String GROUP_NAME="Group1";
	public static final String NODE_NAME="kartk";
	public static final String NODE_IP="10.250.236.67";
	public static final String SERVER_NODE_IP="127.0.0.1";
	public static final String NODE_PORT="4567";
	public static final String SECRET="secret";
	public static final String UDP_IP_BROADCAST = "255.255.255.255";
	public static final Integer UDP_PORT = 8888;
	public static final Integer TEST_PORT = 7777;
	
	public static void main(String args[]) throws Exception{
		String ip = "";
		try {
	        Enumeration networkInterfaces = NetworkInterface.getNetworkInterfaces();  // gets All networkInterfaces of your device
	        while (networkInterfaces.hasMoreElements()) {
	            NetworkInterface inet = (NetworkInterface) networkInterfaces.nextElement();
	            Enumeration address = inet.getInetAddresses();
	            while (address.hasMoreElements()) {
	                InetAddress inetAddress = (InetAddress) address.nextElement();
	                if (inetAddress.isLinkLocalAddress() && inetAddress.getHostAddress().length()<16) {
	                	ip = inetAddress.getHostAddress();
	                    System.out.println("Your ip: " + inetAddress.getHostAddress());  /// gives ip address of your device
	                }
	            }
	        }
	    } catch (Exception e) {
	        // Handle Exception
	    }
		System.out.println("here"+ip);
		//return ip;
	}
}
package gash.router.app;

import gash.router.client.MessageClient;
import gash.router.server.MessageServer;

import java.io.File;

import routing.Pipe.CommandMessage;

public class QueueServerApp {


	 private static int  id;
	//protected RingNode previous;
	//ip of previous server
		//protected static String next="169.254.67.22";
	protected static String next="169.254.121.22";
		//169.254.52.52
	//protected RingNode next;
	//ip of next server
	protected static String previous="169.254.85.237";

	private QueueServer server;
	private static MessageClient client;


	public QueueServerApp() {
		
		}
	public QueueServerApp(int id) {

		this.id=id;
		
		
		File cf = new File("runtime/queueServer.conf");
		try {
			server = new QueueServer(cf);
			server.startServer();
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			System.out.println("server closing");
		}
	}

	/**
	 * sample application (client) use of our messaging service
	 * 
	 * @param args
	 */
	public static void main(String[] args) {
		//String host = "169.254.82.122";
		//int port = 4567;
		System.out.println("test");
		QueueServerApp app= new QueueServerApp(0);
		
	}
}

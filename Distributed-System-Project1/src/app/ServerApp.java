package app;

import java.io.File;
import client.MessageClient;
import server.MessageServer;
import routing.Pipe.CommandMessage;

public class ServerApp {

	private static int  id;
	private MessageServer server;
	private static MessageClient client;

	public ServerApp() {

	}
	public ServerApp(int id, String pathname) {
		this.id = id;

		File cf = new File(pathname);
		try {
			server = new MessageServer(cf);
			server.startServer();
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			System.out.println("server closing");
		}
	}
	/**
	* sample application (client) use of our messaging service
	* @param args
	*/
	public static void main(String[] args) {
		String pathname = "runtime/route-1.conf";
		if (args.length == 0) {
			System.out.println("usage: server" + pathname);
		} else {
			pathname = args[0];
			System.out.println("usage: server" + args[0]);
		}
		ServerApp app = new ServerApp(0, pathname);
	}
}




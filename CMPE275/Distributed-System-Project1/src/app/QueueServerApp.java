package app;

import java.io.File;
import routing.Pipe.CommandMessage;

public class QueueServerApp {
	private static int  id;
	private QueueServer server;

	public QueueServerApp() {

	}
	public QueueServerApp(int id, String pathname) {

		this.id = id;
		File cf = new File(pathname);
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
	* @param args
	*/
	public static void main(String[] args) {
		String pathname = "runtime/queueServer.conf";
		if (args.length == 0) {
			System.out.println("usage: server" + pathname);
		} else {
			pathname = args[0];
			System.out.println("usage: server" + args[0]);
		}
		System.out.println("QueueServerApp");
		QueueServerApp app = new QueueServerApp(0 , pathname);//
	}
}

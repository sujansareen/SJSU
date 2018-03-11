package gash.socket.client;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.util.Properties;

/**
 * console interface to the socket example
 * 
 * @author gash
 * 
 */
public class BasicClientApp {
	private Properties setup;

	public BasicClientApp(Properties setup) {
		this.setup = setup;
	}

	public void run() {

		BufferedReader br = new BufferedReader(new InputStreamReader(System.in));

		String name = null;
		String group = null;
		
		do {
			try {
				
				if (name == null) {
					System.out.print("Enter a name: ");
					System.out.flush();
					name = br.readLine();
				}
				if (group == null) {
					System.out.print("Enter a group: ");
					System.out.flush();
					group = br.readLine();
				}
				System.out.println("");
			} catch (Exception e2) {
			}

			if (name != null)
				break;
		} while (true);

		BasicClient bc = new BasicClient(setup);
		bc.startSession();
		bc.setName(name);
		bc.join(name);

		System.out.println("\nWelcome " + name + "\n");
		showMenu();

		boolean forever = true;
		while (forever) {	
			try {
				System.out.print(group + "> ");
				String choice = br.readLine();

				if (choice == null) {
					continue;
				} else if (choice.equalsIgnoreCase("whoami")) {
					System.out.println("You are " + bc.getName());
				} else if (choice.equalsIgnoreCase("exit")) {
					System.out.println("EXIT CMD!");
					bc.stopSession();
					forever = false;
				} else if (choice.equalsIgnoreCase("group")) {
					System.out.print("Enter group: ");
					String tmp = br.readLine().trim().toLowerCase();
					if ( tmp.length() > 0 ) group = tmp;
				} else if (choice.equalsIgnoreCase("post")) {
					System.out.print("Enter message: ");
					String msg = br.readLine();
					bc.sendMessage(msg);
				} else if (choice.equalsIgnoreCase("help")) {
					showMenu();
					
				} else {
					bc.sendMessage(choice);
				}
			} catch (Exception e) {
				forever = false;
				e.printStackTrace();
			}
		}

		System.out.println("\nGoodbye");
		bc.stopSession();
	}

	private void showMenu() {
		System.out.println("");
		System.out.println("Commands");
		System.out.println("-----------------------------------------------");
		System.out.println("help - show this menu");
		System.out.println("post - send a message to the group (default)");
		System.out.println("whoami - list my settings");
		System.out.println("group - change/create a group");
		System.out.println("exit - end session");
		System.out.println("");
	}
	
	public static void main(String[] args) {
		Properties p = new Properties();
		p.setProperty("host", "127.0.0.1");
		p.setProperty("port", "2100");

		BasicClientApp ca = new BasicClientApp(p);
		ca.run();
	}
}

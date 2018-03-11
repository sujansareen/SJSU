/**
 * Copyright 2016 Gash.
 *
 * This file and intellectual content is protected under the Apache License, version 2.0
 * (the "License"); you may not use this file except in compliance with the
 * License.  You may obtain a copy of the License at:
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.  See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */
package gash.router.server;

import java.io.File;
import java.io.IOException;
import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;
import java.util.logging.Level;
import java.util.logging.Logger;


/**
 * @author gash1
 * 
 */
public class MessageApp implements Runnable {

	/**
	 * @param args
	 */
	DatagramSocket socket;

	public static void main(String[] args) {
		if (args.length == 0) {
			System.out.println("usage: server <config file>");
			System.exit(1);
		}
		Thread discoveryThread = new Thread(MessageApp.getInstance());
		discoveryThread.start();
		File cf = new File(args[0]);
		try {
			MessageServer svr = new MessageServer(cf);
			svr.startServer();
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			System.out.println("server closing");
		}
	}

	@Override
	public void run() {
		try {
			// Keep a socket open to listen to all the UDP traffic that is destined for this
			// port
			socket = new DatagramSocket(4567, InetAddress.getByName("0.0.0.0"));
			socket.setBroadcast(true);

			while (true) {
				System.out.println(getClass().getName() + ">>>Ready to receive UDP broadcast packets!");

				// Receive a packet
				byte[] recvBuf = new byte[15000];
				DatagramPacket packet = new DatagramPacket(recvBuf, recvBuf.length);
				socket.receive(packet);

				// Packet received
				System.out.println(getClass().getName() + ">>>Discovery packet received from: "
						+ packet.getAddress().getHostAddress());
				System.out.println(getClass().getName() + ">>>Packet received; data: " + new String(packet.getData()));

				// See if the packet holds the right command (message)
				String message = new String(packet.getData()).trim();
				if (message.equals("DISCOVER_SERVER_REQUEST")) {
					byte[] sendData = "DISCOVER_SERVER_RESPONSE".getBytes();

					// Send a response
					DatagramPacket sendPacket = new DatagramPacket(sendData, sendData.length, packet.getAddress(),
							packet.getPort());
					socket.send(sendPacket);

					System.out.println(
							getClass().getName() + ">>>Sent packet to: " + sendPacket.getAddress().getHostAddress());
				}
			}
		} catch (IOException ex) {
			Logger.getLogger(MessageApp.class.getName()).log(Level.SEVERE, null, ex);
		}
	}

	public static MessageApp getInstance() {
		return MessageAppHolder.INSTANCE;
	}

	private static class MessageAppHolder {

		private static final MessageApp INSTANCE = new MessageApp();
	}
}

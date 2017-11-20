package app;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.BufferedInputStream;
import java.io.File;
import java.io.FileInputStream;

import com.google.protobuf.ByteString;

import client.CommInit;
import io.netty.channel.Channel;
import io.netty.bootstrap.Bootstrap;
import io.netty.channel.ChannelFuture;
import io.netty.channel.ChannelOption;
import io.netty.channel.EventLoopGroup;
import io.netty.channel.nio.NioEventLoopGroup;
import io.netty.channel.socket.nio.NioSocketChannel;
import logger.Logger;
import pipe.common.Common.Chunk;
import pipe.common.Common.Header;
import pipe.common.Common.Node;
import pipe.common.Common.Request;
import pipe.common.Common.TaskType;
import pipe.common.Common.WriteBody;
import routing.MsgInterface.Message;
import routing.MsgInterface.Route;
import routing.Pipe.CommandMessage;
import client.CommListener;
import client.MessageClient;
import client.CommConnection;

public class MessageApp implements CommListener {
	private MessageClient mc;

	public MessageApp(MessageClient mc, String uname) {
		destination_id = "destination_id_test";
		init(mc, uname);
	}

	private void init(MessageClient mc, String uname) {
		this.uname = uname;
		this.mc = mc;
		this.mc.addListener(this);
	}
	
	static String host;
	static String uname;
	static String destination_id;
	static int port;
	static ChannelFuture channel;
	
	static EventLoopGroup group;
	static final int chunkSize = 1024; // MAX BLOB STORAGE = Math,pow(2,15) -1 = 65535 Bytes 

	@Override
	public String getListenerID() {
		return uname;
	}

	@Override
	public void onMessage(Route msg) {
		if(msg.hasMessage()){
			Message message = msg.getMessage();
			//TODO: Handle Different cases
			System.out.println("[" + message.getSenderId() + "] " + message.getPayload() + '\n');
			//System.out.println("[you] " + message + '\n');
		}
	}

	public void sendMessage(String message) {
		Route msg = sendMessageBuilder(message);
		mc.sendMessage(msg);
		System.out.println("[you] " + message + '\n');
	}
	public void getMessages() {
		Route msg = getMessagesBuilder();
		mc.sendMessage(msg);
	}

	public static Route sendMessageBuilder(String message){
		Message.Builder msg=Message.newBuilder();
		msg.setType(Message.Type.SINGLE);
		msg.setSenderId(uname);
		msg.setPayload(message);
		msg.setReceiverId(destination_id);
		msg.setTimestamp("10:01");
		msg.setAction(Message.ActionType.POST);
		
		Route.Builder route= Route.newBuilder();
		route.setId(123);
		route.setPath(Route.Path.MESSAGE);
		route.setMessage(msg);
		return route.build();
	}
	public static Route getMessagesBuilder(){
		Message.Builder msg = Message.newBuilder();
		msg.setType(Message.Type.SINGLE);
		msg.setSenderId(uname);
		msg.setReceiverId(destination_id);
		msg.setTimestamp("10:01");
		msg.setAction(Message.ActionType.POST);
		msg.setPayload("");

		Route.Builder route= Route.newBuilder();
		route.setId(123);
		route.setPath(Route.Path.MESSAGES_REQUEST);
		route.setMessage(msg);
		return route.build();
	}
	

	public static void main(String[] args) {
		String host = "127.0.0.1";
		int port = 4168;
		MessageClient mc;
		MessageApp da = null;
		try {
			ChannelFuture lastWriteFuture = null;
			BufferedReader in = new BufferedReader(new InputStreamReader(System.in));
			System.out.print("Username: ");
			for (;;) {

				String line = in.readLine();
				if (line == null) {
					break;
				}

				if(da == null){
					mc = new MessageClient(host, port);
					da = new MessageApp(mc, line);
					Thread.sleep(1 * 1000);
					// do stuff w/ the connection
					System.out.println( "Welcome to " + line + " chat service!\n");
					da.getMessages();
					System.out.println("+++++++++++++++++++++++++");
					Thread.sleep(1 * 1000);

				} else {
					// TODO: Team - more conditions like "groupid".equals(line.toLowerCase())

					// Sends the received line to the server.
					da.sendMessage(line);

					// If user typed the 'bye' command, wait until the server closes
					// the connection.
				}
				if ("bye".equals(line.toLowerCase())) {
					break;
				}
			}
			// Wait until all messages are flushed before closing the channel.
			if (lastWriteFuture != null) {
				lastWriteFuture.sync();
			}

			System.out.flush();

		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			CommConnection.getInstance().release();
		}

	}


}

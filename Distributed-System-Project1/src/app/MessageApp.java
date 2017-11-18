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

	public MessageApp(MessageClient mc) {
		init(mc);
	}

	private void init(MessageClient mc) {
		uname = "arturo";
		this.mc = mc;
		this.mc.addListener(this);
	}
	
	static String host;
	static String uname;
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
		System.out.println("---> " + msg);
	}

	public void sendMessage(String message,String destination_id) {
		Route test = writeMessage(message, destination_id);
		mc.sendMessage(test);
	}

	public static Route writeMessage(String message,String destination_id){
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
	public static Route getMessages(String destination_id){
		Message.Builder msg = Message.newBuilder();
		msg.setType(Message.Type.SINGLE);
		msg.setSenderId(destination_id);
		msg.setReceiverId(uname);
		msg.setTimestamp("10:01");
		msg.setAction(Message.ActionType.POST);

		Route.Builder route= Route.newBuilder();
		route.setId(123);
		route.setPath(Route.Path.MESSAGES_REQUEST);
		route.setMessage(msg);
		return route.build();
	}
	

	public static void main(String[] args) {
		String uname = null;
		String host = "127.0.0.1";
		int port = 4168;

		try {
			MessageClient mc = new MessageClient(host, port);
			MessageApp da = new MessageApp(mc);
			Thread.sleep(1 * 1000);
			// do stuff w/ the connection
			ChannelFuture lastWriteFuture = null;
			BufferedReader in = new BufferedReader(new InputStreamReader(System.in));
			System.out.print("Username: ");
			for (;;) {

				String line = in.readLine();
				if (line == null) {
					break;
				}

				if(uname == null){
					uname = line;
					System.out.println("+++++++++++++++++++++++++");
					// TODO: Team - get messages
				} else {
					// TODO: Team - more conditions like "groupid".equals(line.toLowerCase())

					// Sends the received line to the server.
					da.sendMessage(line, "testUser");

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

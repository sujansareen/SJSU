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

public class TestClient {

	
	static String host;
	static int port;
	static ChannelFuture channel;
	
	static EventLoopGroup group;
	static final int chunkSize = 1024; // MAX BLOB STORAGE = Math,pow(2,15) -1 = 65535 Bytes 

	
	public static void init(String host_received, int port_received)
	{
		host = host_received;
		port = port_received;
		group = new NioEventLoopGroup();
		try {
			CommInit si = new CommInit(false);
			Bootstrap b = new Bootstrap();
			b.group(group).channel(NioSocketChannel.class).handler(si);
			b.option(ChannelOption.CONNECT_TIMEOUT_MILLIS, 10000);
			b.option(ChannelOption.TCP_NODELAY, true);
			b.option(ChannelOption.SO_KEEPALIVE, true);


			// Make the connection attempt.
//			 channel = b.connect(host, port).syncUninterruptibly();
			// Start the connection attempt.
			Channel ch = b.connect(host, port).sync().channel();
			//
			ChannelFuture lastWriteFuture = null;
			BufferedReader in = new BufferedReader(new InputStreamReader(System.in));
			for (;;) {
				String line = in.readLine();
				if (line == null) {
					break;
				}

				// Sends the received line to the server.
				Route message = writeMessage(line,"client1");
				lastWriteFuture = ch.writeAndFlush(message);

				// If user typed the 'bye' command, wait until the server closes
				// the connection.
				if ("bye".equals(line.toLowerCase())) {
					ch.closeFuture().sync();
					break;
				}
			}

			// Wait until all messages are flushed before closing the channel.
			if (lastWriteFuture != null) {
				lastWriteFuture.sync();
			}


			// want to monitor the connection to the server s.t. if we loose the
			// connection, we can try to re-establish it.
			// ClientClosedListener ccl = new ClientClosedListener(this);
			// channel.channel().closeFuture().addListener(ccl);

			System.out.println(channel.channel().localAddress() + " -> open: " + channel.channel().isOpen()
					+ ", write: " + channel.channel().isWritable() + ", reg: " + channel.channel().isRegistered());

		} catch (Throwable ex) {
			System.out.println("failed to initialize the client connection " + ex.toString());
			ex.printStackTrace();
		}

	}
	
	/* TODO: Group	*/

	public static Route writeMessage(String message,String destination_id){
		Message.Builder msg=Message.newBuilder();
		msg.setType(Message.Type.SINGLE);
		msg.setSenderId("dhanashree");
		msg.setPayload(message);
		msg.setReceiverId(destination_id);
		msg.setTimestamp("10:01");
		msg.setAction(Message.ActionType.POST);
		
		Route.Builder route= Route.newBuilder();
		route.setId(123);
		route.setPath(Route.Path.MESSAGE);
		route.setMessage(msg);
		Route routeMessage= route.build();
		return routeMessage;
	}
	public static Route getMessages(String message,String destination_id){
		Message.Builder msg=Message.newBuilder();
		msg.setType(Message.Type.SINGLE);
		msg.setSenderId("dhanashree");
		msg.setPayload(message);
		msg.setReceiverId(destination_id);
		msg.setTimestamp("10:01");
		msg.setAction(Message.ActionType.POST);

		Route.Builder route= Route.newBuilder();
		route.setId(123);
		route.setPath(Route.Path.MESSAGES_REQUEST);
		route.setMessage(msg);
		Route routeMessage= route.build();
		return routeMessage;
//		channel.channel().writeAndFlush(routeMessage);
//		if (channel.isDone() && channel.isSuccess()) {
//			System.out.println("Msg sent succesfully:");
//		}
	}
	

	public static void main(String[] args) {
		
		String host = "127.0.0.1";
		int port = 4167;
		
		System.out.println("Sent the message");
		TestClient.init(host, port);
//		File file = new File("runtime/log.txt");
		//TestClient.writeMessage("Hello Dhanashree","client1");
		//TestClient.getMessages("Hello Dhanashree","client1");
		// TODO Auto-generated method stub
		
	}


}

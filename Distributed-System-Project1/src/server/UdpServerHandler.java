package server;

import java.util.Random;

import io.netty.channel.ChannelHandlerContext;
import io.netty.channel.SimpleChannelInboundHandler;
import routing.MsgInterface.NetworkDiscoveryPacket;
import routing.MsgInterface.NetworkDiscoveryPacket.Mode;
import routing.MsgInterface.NetworkDiscoveryPacket.Sender;
import routing.MsgInterface.Route;
import app.MyConstants;
import client.UdpClient;;

public class UdpServerHandler extends SimpleChannelInboundHandler<Route> {

	private static final Random random = new Random();
	// private static Map<String, Node> mp = Collections.emptyMap();
	// private static Map<String, Map<String, Node>> mpMaps =
	// Collections.emptyMap();

	// public static Map<String, Node> NodeMap= new HashMap<>();

	/*
	 * public static Map<String, Map<String, Node>> GroupMap = new HashMap<String,
	 * Map<String, Node>>();
	 */

	@Override
	public void channelRead0(ChannelHandlerContext ctx, Route route) throws Exception {
		System.out.println("Recieved a datagram packet " + route);
		NetworkDiscoveryPacket request = route.getNetworkDiscoveryPacket();
		System.out.println("Recieved a packet from " + request.getNodeAddress());
		// Do nothing when the received packet is your own udp request packet bearing your own IP
		/*if (MyConstants.SERVER_NODE_IP.equals(request.getNodeAddress())) {
			return;
		}*/

		/*if (request.getSender().equals(Sender.EXTERNAL_SERVER_NODE)) {
			ClusterDirectory.addToDirectory(request);
		}*/

		if (request.getMode() == NetworkDiscoveryPacket.Mode.REQUEST) {

			try {

				Route.Builder rb = Route.newBuilder();
				rb.setPath(Route.Path.NETWORK_DISCOVERY);

				NetworkDiscoveryPacket.Builder toSend = NetworkDiscoveryPacket.newBuilder();
				toSend.setGroupTag(MyConstants.GROUP_NAME);

				toSend.setNodeId("testServer");
				toSend.setNodeAddress("127.0.0.1");
				toSend.setMode(Mode.RESPONSE);
				//toSend.setNodePort(Integer.parseInt(MyConstants.NODE_PORT));
				toSend.setNodePort(4168);
				toSend.setSender(Sender.EXTERNAL_SERVER_NODE);
				toSend.setSecret(MyConstants.SECRET);

				rb.setNetworkDiscoveryPacket(toSend);
				rb.setId(1);
				Route response = rb.build();
				//UdpClient.sendUDPMessage(response, request.getNodeAddress(), MyConstants.UDP_PORT);
				UdpClient.sendUDPMessage(response, MyConstants.UDP_IP_BROADCAST, MyConstants.TEST_PORT);
			} catch (Exception e) {
				System.err.println("Exception received");
				e.printStackTrace();
			}
		}
	}

	@Override
	public void channelReadComplete(ChannelHandlerContext ctx) {
		ctx.flush();
	}

	@Override
	public void exceptionCaught(ChannelHandlerContext ctx, Throwable cause) {
		cause.printStackTrace();
		// We don't close the channel because we can keep serving requests.
	}
}

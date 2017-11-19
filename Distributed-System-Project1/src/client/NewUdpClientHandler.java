package client;

import java.util.Random;

import io.netty.channel.ChannelHandlerContext;
import io.netty.channel.SimpleChannelInboundHandler;
import routing.MsgInterface.NetworkDiscoveryPacket;
import routing.MsgInterface.NetworkDiscoveryPacket.Mode;
import routing.MsgInterface.NetworkDiscoveryPacket.Sender;
import routing.MsgInterface.Route;
import app.MyConstants;
import app.TestClient;
import client.UdpClient;;

public class NewUdpClientHandler extends SimpleChannelInboundHandler<Route> {


	@Override
	public void channelRead0(ChannelHandlerContext ctx, Route route) throws Exception {
		System.out.println("Recieved a datagram packet " + route);
		System.out.println("***************lets begin test****************");
		String toConnectIP = route.getNetworkDiscoveryPacket().getNodeAddress();
		TestClient.init(toConnectIP, 4167);
		TestClient.writeMessage("Hello Gash","client1");
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

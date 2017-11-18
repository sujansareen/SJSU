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
package server;

import org.slf4j.Logger;

import org.slf4j.LoggerFactory;

import app.ServerApp;
import container.RoutingConf;
import routing.MsgInterface;
import server.raft.NodeState;
import server.tasks.TaskList;
import io.netty.channel.Channel;
import io.netty.channel.ChannelHandlerContext;
import io.netty.channel.SimpleChannelInboundHandler;
import pipe.common.Common.Failure;
//import pipe.common.Common.Failure;
//import pipe.common.Common.Request.RequestType;
import routing.Pipe.CommandMessage;
import routing.MsgInterface.Route;
import io.netty.channel.group.ChannelGroup;
import io.netty.channel.group.DefaultChannelGroup;
import io.netty.util.concurrent.GlobalEventExecutor;

/**
 * The message handler processes json messages that are delimited by a 'newline'
 * 
 * TODO replace println with logging!
 * 
 * @author gash
 * 
 */
public class CommandHandler extends SimpleChannelInboundHandler<Route> {
	protected static Logger logger = LoggerFactory.getLogger("cmd");
	static final ChannelGroup channels = new DefaultChannelGroup(GlobalEventExecutor.INSTANCE);

	protected RoutingConf conf;
	protected ServerState state;
	
	public CommandHandler(RoutingConf conf, ServerState state) {
		if (conf != null) {
			this.conf = conf;
		}
		if(state != null){
			this.state = state;
		}
	}
	public static Route sendMessageBack(){
		MsgInterface.Message.Builder msg= MsgInterface.Message.newBuilder();
		msg.setType(MsgInterface.Message.Type.SINGLE);
		msg.setSenderId("");
		msg.setReceiverId("");
		msg.setTimestamp("10:01");
		msg.setAction(MsgInterface.Message.ActionType.POST);

		Route.Builder route= Route.newBuilder();
		route.setId(123);
		route.setPath(Route.Path.MESSAGES_REQUEST);
		route.setMessage(msg);
		return route.build();
	}
	/**
	 * override this method to provide processing behavior. This implementation
	 * mimics the routing we see in annotating classes to support a RESTful-like
	 * behavior (e.g., jax-rs).
	 * 
	 * @param msg
	 */
	public void handleMessage(Route msg, Channel channel) {
		
		if (msg == null) {
			// TODO add logging
			System.out.println("ERROR: Unexpected content - " + msg);
			return;
		}
       // ServerApp.propagateMessage(msg);
		//PrintUtil.printCommand(msg);
         
		try {
			System.out.println("Hello: content - " + msg.toString() );
			channel.write(sendMessageBack());
			// if (msg.hasPing()) {
		} catch (Exception e) {
			// TODO add logging
			Failure.Builder eb = Failure.newBuilder();
			eb.setId(conf.getNodeId());
			//eb.setRefId(msg.getHeader().getNodeId());
			eb.setMessage(e.getMessage());
			Route.Builder rb = Route.newBuilder(msg);
			//rb.setErr(eb);
			channel.write(rb.build());
		}
		
//		state.getTasks().dequeue();
		System.out.flush();
	}

	/**
	 * a message was received from the server. Here we dispatch the message to
	 * the client's thread pool to minimize the time it takes to process other
	 * messages.
	 * 
	 * @param ctx
	 *            The channel the message was received from
	 * @param msg
	 *            The message
	 */
	@Override
	protected void channelRead0(ChannelHandlerContext ctx, Route msg) throws Exception {
		handleMessage(msg, ctx.channel());	
	}

	@Override
	public void exceptionCaught(ChannelHandlerContext ctx, Throwable cause) throws Exception {
		logger.error("Unexpected exception from downstream.", cause);
		ctx.close();
	}

}